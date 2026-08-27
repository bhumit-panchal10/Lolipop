@extends('layouts.app')
@section('title', 'Inward List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                @if ($errors->any())
                    {{--  <h5 style="color:red">Following errors exists in your excel file</h5>  --}}
                    <ol>
                        @foreach ($errors->all() as $error)
                            <p style="color:red">{{ $error }}</p>
                        @endforeach
                    </ol>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="display: flex;justify-content: space-between;">
                                <div>
                                    <h5 class="card-title mb-0">Add Product Inward</h5>
                                </div>
                                <div>    
                                    <a href="#" data-bs-toggle="modal" title="Delete" data-bs-target="#AddModal"
                                        class="btn btn-sm btn-primary mx-2">
                                        <i class="fa-solid fa-plus"></i> Add New
                                    </a>
                                     <a href="{{ route('product.index') }}"
                                        class="btn btn-sm btn-primary mx-2">
                                          Back
                                    </a>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade flip" id="AddModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Add Product Inward</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form id="regForm" action="{{ route('product.product_inward_store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">

                                    <input type="hidden" name="productid" value="{{ $id }}">

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Size
                                        <select class="form-control" name="iSize" id="">
                                            <option value="">Select Size</option>
                                            @foreach ($GetSize as $data)
                                                <option value="{{ $data->id }}">{{ $data->product_attribute_size }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <span style="color:red;">*</span>Qty
                                        <input type="text" class="form-control" name="iQty"
                                            oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*?)\..*/g, '$1');"
                                            placeholder="Enter Qty" maxlength="100" autocomplete="off" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary mx-2" id="add-btn">Submit
                                        </button>
                                        <button type="button" class="btn btn-primary mx-2" data-bs-dismiss="modal">Cancel
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    Product Name :- {{ $Product->productname }}
                                </h5>
                                <h5 class="card-title mb-0">
                                    <a href="{{ asset('Product/Thumbnail/') . '/' . $Product->photo }}" target="_blank">
                                        <img class="img-1" height="50" width="50" src="{{ asset('Product/Thumbnail/') . '/' . $Product->photo }}">
                                    </a>     
                                </h5>
                            </div>
                            <div class="card-body">

                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Opening Balance</th>
                                            <th scope="col">Purchase</th>
                                            <th scope="col">Sales</th>
                                            <th scope="col">Closing Balance</th>
                                            <!--<th scope="col">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($ProductAttributes as $data)
                                            <tr class="text-center">
                                                <td>
                                                    {{ $i + $ProductAttributes->perPage() * ($ProductAttributes->currentPage() - 1) }}
                                                </td>
                                                <td>{{ $data->Size }}</td>
                                                <td>{{ (int)$data->openingBalance }}</td>
                                                <td>{{ (int)$data->cr }}</td>
                                                <td>{{ (int)$data->dr }}</td>
                                                <td>{{ (int)$data->closingBalance }}</td>

                                                <!--<td>-->
                                                <!--    @if ($data->iOrderId != 0 && $data->iOrderDetailId != 0)-->
                                                <!--        <div class=" gap-2">-->
                                                <!--            <a class="" href="#" data-bs-toggle="modal"-->
                                                <!--                title="Delete" data-bs-target="#deleteRecordModal"-->
                                                <!--                onclick="deleteData(<?= $data->inwardId ?>);">-->
                                                <!--                <i class="fa fa-trash" aria-hidden="true"></i>-->
                                                <!--            </a>-->
                                                <!--        </div>-->
                                                <!--    @endif-->
                                                <!--</td>-->

                                            </tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $ProductAttributes->links() }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <!--Delete Modal Start -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mt-2 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px">
                                    </lord-icon>
                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                        <h4>Are you Sure ?</h4>
                                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record
                                            ?</p>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                    <a class="btn btn-primary mx-2" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('user-delete-form').submit();">
                                        Yes,
                                        Delete It!
                                    </a>
                                    <button type="button" class="btn w-sm btn-primary mx-2"
                                        data-bs-dismiss="modal">Close</button>
                                    <form id="user-delete-form" method="POST"
                                        action="{{ route('product.product_inward_delete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="inwardId" id="deleteid" value="">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Delete modal End -->

            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
        
        $(document).ready(function() {
            $('#regForm').on('submit', function () {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

@endsection
