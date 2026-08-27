@extends('layouts.app')

@section('title', 'Order Collection')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0">Order Collection</h5>
                        </div>

                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" id="form" action="{{ route('report.order_collection') }}">
                                            @csrf
                                            <div class="row align-items-center">
                                                {{-- optional: remove order_no input if you don't want it --}}
                                                <div class="col-md-3  mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <input placeholder="Enter Customer Name" type="text"
                                                            class="form-control" name="customer_name"
                                                            autocomplete="off"
                                                            value="<?= isset($CustomerName) ? $CustomerName : '' ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3  mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <input placeholder="Enter Mobile" type="text"
                                                            class="form-control" name="mobile"
                                                            autocomplete="off"
                                                            value="<?= isset($Mobile) ? $Mobile : '' ?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-3 mb-2">
                                                    <input placeholder="Enter Order No" type="text"
                                                        class="form-control" name="order_no" autocomplete="off"
                                                        value="{{ old('order_no', $OrderNo ?? '') }}">
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    <input placeholder="Enter From Date" type="text"
                                                        class="form-control" id="startdatepicker" name="fromdate"
                                                        autocomplete="off" value="{{ old('fromdate', $FromDate ?? '') }}">
                                                </div>

                                                <div class="col-md-3 mb-2">
                                                    <input placeholder="Enter To Date" type="text"
                                                        class="form-control" id="enddatepicker" name="todate"
                                                        autocomplete="off" value="{{ old('todate', $ToDate ?? '') }}">
                                                </div>

                                                <div class="col-md-6 col-lg-3 mb-2">
                                                    <div class="input-group d-flex justify-content-right">
                                                        <button type="submit" class="btn btn-primary mx-2">Search</button>
                                                        <a class="btn btn-primary mx-2" href="{{ route('report.order_collection') }}">Cancel</a>
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

                                                        {{-- Only show table if controller provided $datas and there are results --}}
                                                        @if(isset($datas) && $count > 0)
                                                            <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
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

                                                                <tbody>
                                                                    @php $i = 1; @endphp
                                                                    @foreach ($datas as $data)
                                                                        <?php 
                                                                        $detail = App\Models\OrderDetail::select('orderdetail.*',DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),)->orderBy('orderDetailId', 'DESC')
                                                                            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
                                                                            ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
                                                                            ->join('product', 'orderdetail.productId', '=', 'product.productId')
                                                                            ->get();
                                                                            $Count = $detail->count() + 3;
                                                                        ?>

                                                                        <tr class="text-center">
                                                                            <td>{{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}</td>
                                                                            <td>{{ $data->order_id }}</td>
                                                                            <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                                                            <td>{{ $data->shipping_cutomerName }}</td>
                                                                            <td>{{ $data->shipping_email }}</td>
                                                                            <td>{{ $data->shipping_mobile }}</td>
                                                                            <td>
                                                                                @if ($data->isPayment == 0)
                                                                                    Payment Pending
                                                                                @elseif ($data->isPayment == 1)
                                                                                    Success
                                                                                @else
                                                                                    Failed
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($data->url && $data->docketNo)
                                                                                    <a target="_blank" href="{{ $data->url . $data->docketNo }}">
                                                                                        {{ $data->courier_name }}
                                                                                    </a>
                                                                                @else
                                                                                     Not Yet Dispatched
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $data->docketNo ?? "-" }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                                <td colspan="10" class="des-ll">
                                                                                    
                                                                                   <div class="d-flex justify-content-between">
    
                                                                                    <a class="mx-2"
                                                                                        href="{{ route('order.orderdetail', $data->order_id) }}"
                                                                                        title="Details">
                                                                                        <i class="fa-solid fa-circle-info fa-lg"></i>
                                                                                        View Order Details
                                                                                    </a>
    
                                                                                    <a class="mx-2" target="_blank"
                                                                                        href="{{ route('order.DetailPDF', $data->order_id) }}"
                                                                                        title="Pdf Details">
                                                                                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Order PDF
                                                                                    </a>
                                                                                    
                                                                                    <a class="mx-2" 
                                                                                        href="{{ route('report.send_confirmation_message', $data->order_id) }}"
                                                                                        title="Pdf Details">
                                                                                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Confirmation Message
                                                                                    </a>
                                                                                    
                                                                                    <a class="mx-2" 
                                                                                        href="{{ route('report.send_whatsapp_tracking_link', $data->order_id) }}"
                                                                                        title="Send Whatsapp Tracking Link">
                                                                                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Send Whatsapp Tracking Link
                                                                                    </a>
                                                                                    
                                                                                    <a class="mx-2" target="_blank"
                                                                                        href="{{ route('order.DispatchPDF', $data->order_id) }}"
                                                                                        title="Dispatch Pdf Details">
                                                                                        <i class="fa-solid fa-file-pdf fa-lg"></i>
                                                                                        Dispatch Order Sticker PDF
                                                                                    </a>
                                                                               </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> &nbsp; </td>
                                                                            </tr>

                                                                        @php $i++; @endphp
                                                                    @endforeach

                                                                    {{-- Total Collection row (only shows when we have results) --}}
                                                                    <tr class="text-center font-weight-bold bg-light">
                                                                        <td colspan="8" class="text-end">Total Collection:</td>
                                                                        <td>₹{{ number_format((float) ($collection ?? 0), 2) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $datas->appends(request()->except('page'))->links() }}
                                                            </div>

                                                        @else
                                                            {{-- No data message (only display when search was attempted or $datas exists but empty) --}}
                                                            @if(isset($datas))
                                                                <div class="alert alert-info text-center">No Data Found !</div>
                                                            @else
                                                                {{-- initial page load -- keep it empty (no message) --}}
                                                            @endif
                                                        @endif

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
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>
    $(function() {
        $("#startdatepicker").datepicker({
            dateFormat: 'd-m-yy'
        });
        $("#enddatepicker").datepicker({
            dateFormat: 'd-m-yy'
        });
    });
</script>
@endsection
