@extends('layouts.app')

@section('title', 'Search Customer')

@section('content')


    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-xxl-12">
                        <h5 class="mb-3"></h5>
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0">Customer Search</h5>
                            </div>
                            <div class="card-body">
                                <!-- Nav tabs -->

                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="form"
                                                action="{{ route('report.searchCustomer') }}">
                                                @csrf
                                                <div class="row  align-items-center">
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter Order No" type="text"
                                                                class="form-control" name="order_no" autocomplete="off"
                                                                value="<?= isset($OrderNo) ? $OrderNo : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter Name" type="text"
                                                                class="form-control" name="strName" autocomplete="off"
                                                                value="<?= isset($Name) ? $Name : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3  mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <input placeholder="Enter Mobile" type="text"
                                                                class="form-control" name="strMobile" autocomplete="off"
                                                                value="<?= isset($Mobile) ? $Mobile : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-3  mb-2">
                                                        <div class="input-group d-flex justify-content-right">
                                                            <button type="submit" class="btn btn-primary mx-2">
                                                                Search
                                                            </button>
                                                            <a class="btn btn-primary mx-2"
                                                                href="{{ route('report.searchCustomer') }}">
                                                                Cancel
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-content text-muted">
                                    <div class="tab-pane active" id="PendingOrder" role="tabpanel">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive">

                                                            <?php if(!empty($datas)){ ?>
                                                            <table id="scroll-horizontal" class="table nowrap align-middle"
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="all">Sr.No</th>
                                                                        <th class="all">Order No</th>
                                                                        <th class="all">Order Date</th>
                                                                        <th class="all">Customer Name</th>
                                                                        <th class="all">Email</th>
                                                                        <th class="all">Mobile</th>
                                                                        <th class="all">Payment Status</th>
                                                                        <th class="all">Courier Name</th>
                                                                        <th class="all">Docket No</th>
                                                                    </tr>
                                                                </thead>
                                                                <?php if($count > 0){ ?>
                                                                <tbody>
                                                                    <?php $i = 1; ?>
                                                                    @foreach ($datas as $data)
                                                                        <?php
                                                                        $detail = App\Models\OrderDetail::select('orderdetail.*', DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'))
                                                                            ->orderBy('orderDetailId', 'DESC')
                                                                            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
                                                                            ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
                                                                            ->join('product', 'orderdetail.productId', '=', 'product.productId')
                                                                            ->get();
                                                                        $Count = $detail->count() + 3;
                                                                        ?>
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                {{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}
                                                                            </td>
                                                                            <td>{{ $data->order_id }}</td>
                                                                            <td>{{ date('d-m-Y', strtotime($data->created_at)) }}
                                                                            </td>
                                                                            <td>{{ $data->shipping_cutomerName }}</td>

                                                                            <td>{{ $data->shipping_email }}</td>
                                                                            <td>{{ $data->shipping_mobile }}</td>
                                                                            <td>
                                                                                @if ($data->isPayment == 0)
                                                                                    Payment Pending
                                                                                @elseif($data->isPayment == 1)
                                                                                    Success
                                                                                @else
                                                                                    Failed
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if ($data->url && $data->docketNo)
                                                                                    <a target="_blank"
                                                                                        href="{{ $data->url . $data->docketNo }}">
                                                                                        {{ $data->courier_name ?? 'Not Yet Dispatched' }}
                                                                                    </a>
                                                                                @else
                                                                                    Not Yet Dispatched
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $data->docketNo ?? '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="10" class="des-ll">

                                                                                <div class="d-flex justify-content-between">

                                                                                    <a class="mx-2"
                                                                                        href="{{ route('order.orderdetail', $data->order_id) }}"
                                                                                        title="Details">
                                                                                        <i
                                                                                            class="fa-solid fa-circle-info fa-lg"></i>
                                                                                        View Order Details
                                                                                    </a>

                                                                                    <a class="mx-2" target="_blank"
                                                                                        href="{{ route('order.DetailPDF', $data->order_id) }}"
                                                                                        title="Pdf Details">
                                                                                        <i
                                                                                            class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Order PDF
                                                                                    </a>

                                                                                    <a class="mx-2"
                                                                                        href="{{ route('report.send_confirmation_message', $data->order_id) }}"
                                                                                        title="Pdf Details">
                                                                                        <i
                                                                                            class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Confirmation Message
                                                                                    </a>

                                                                                    {{--  <a class="mx-2"
                                                                                        href="{{ route('report.send_whatsapp_tracking_link', $data->order_id) }}"
                                                                                        title="Send Whatsapp Tracking Link">
                                                                                        <i
                                                                                            class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Send Whatsapp Tracking Link
                                                                                    </a>  --}}

                                                                                    <a class="mx-2" target="_blank"
                                                                                        href="{{ route('order.DispatchPDF', $data->order_id) }}"
                                                                                        title="Dispatch Pdf Details">
                                                                                        <i
                                                                                            class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Dispatch Order Sticker PDF
                                                                                    </a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td> &nbsp; </td>
                                                                        </tr>
                                                                        <?php $i++; ?>
                                                                    @endforeach
                                                                </tbody>
                                                                <?php } else { ?>

                                                                <table class="table table-bordered" id="dataTable"
                                                                    width="100%" cellspacing="0">
                                                                    <thead>
                                                                        <tr>
                                                                            <h1
                                                                                class="text-center alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                                                                No Data Found !</h1>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <?php } ?>

                                                            </table>
                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $datas->appends(request()->except('page'))->links() }}
                                                            </div>
                                                            <?php }else{ ?>
                                                            <table class="table table-bordered" id="dataTable"
                                                                width="100%" cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <h1
                                                                            class="text-center alert alert-info clearfix profile-information padding-all-10 margin-all-0 backgroundDark">
                                                                            No Data Found !</h1>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade flip" id="showModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Courier Detail</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form method="POST" action="{{ route('order.statustodispatched') }}"
                                                autocomplete="off" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="order_id" id="order_id" value="">

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Courier
                                                        <select name="courier" class="form-control" id=""
                                                            required>
                                                            <option value="">Select Courier</option>
                                                            @foreach ($Courier as $courier)
                                                                <option value="{{ $courier->id }}">{{ $courier->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Docket No
                                                        <input type="text" class="form-control" name="docketNo"
                                                            id="Editname" placeholder="Enter Docket No" maxlength="100"
                                                            autocomplete="off" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-success"
                                                            id="add-btn">Submit</button>
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function getEditData(id) {
            $('#order_id').val(id);
        }
    </script>
@endsection
