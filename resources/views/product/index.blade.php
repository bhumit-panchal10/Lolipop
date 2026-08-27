@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<style>
a{color:#000!important}</style>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"
                                style="display: flex;
                            justify-content: space-between;">
                                <h5 class="card-title mb-0">Product List</h5>
                                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-plus"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <div class="col-lg-12">
                    <!-- Page Heading -->
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="form" action="{{ route('product.index') }}">
                                @csrf
                                <div class="row  align-items-center">
                                    <div class="col-md-3  mb-2">
                                        <div class="d-flex align-items-center">
                                            <input placeholder="Enter Product Name" type="text"
                                                class="form-control" name="productName"
                                                autocomplete="off"
                                                value="<?= isset($ProductName) ? $ProductName : '' ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="input-group d-flex justify-content-right">
                                            <button type="submit" class="btn btn-primary mx-3">
                                                Search
                                            </button>
                                            <a href="{{ route('product.index') }}" class="btn btn-primary mx-2">
                                                Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Category Name</th>
                                            <th scope="col">Sub Category Name</th>
                                            <th scope="col">Status</th>
                                            <!--<th scope="col">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach ($Product as $product)
                                            <tr class="text-center">
                                                <td width="1%" rowspan="3">
                                                    {{ $i + $Product->perPage() * ($Product->currentPage() - 1) }}
                                                </td>
                                                <td width="2%" style="background:#9caf88;color:#fff">{{ $product->productname }}</td>
                                                <td width="2%">
                                                    <a target="_blank" href="{{ asset('Product/Thumbnail/').'/'. $product->photo }}">
                                                        <img width="50" height="50" src="{{ asset('Product/Thumbnail/').'/'. $product->photo }}" >
                                                    </a>    
                                                </td>
                                                <td width="2%">
                                                    {{ $product->categoryname }}
                                                </td>
                                                <td width="2%">
                                                    {{ $product->subcategoryname ?? '-' }}
                                                </td>
                                                <td width="2%">
                                                    @if ($product->iStatus == 0)
                                                        <span class="badge btn-danger">Inactive</span>
                                                    @elseif ($product->iStatus == 1)
                                                        <span class="badge btn-primary">Active</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                
                                                    <td width="2%" colspan="5">
                                                        <div class="d-flex justify-content-between">
                                                         @if ($product->iStatus == 0)
                                                            <a href="{{ route('product.status', ['product_id' => $product->productId, 'status' => 1]) }}"
                                                                title="InActive" class="mx-1">
                                                                <i class="fa fa-lock" aria-hidden="true"></i> InActive
                                                            </a>
                                                        @elseif ($product->iStatus == 1)
                                                            <a href="{{ route('product.status', ['product_id' => $product->productId, 'status' => 0]) }}"
                                                                title="Active" class="mx-1">
                                                                <i class="fa fa-unlock" aria-hidden="true"></i> Active
                                                            </a>
                                                        @endif        
                                                        <a class="mx-1" title="Edit"
                                                            href="{{ route('product.edit', $product->productId) }}">
                                                            <i class="far fa-edit"></i> Edit
                                                        </a>
                                                        <a class="mx-1" href="#" data-bs-toggle="modal" title="Delete"
                                                            data-bs-target="#deleteRecordModal"
                                                            onclick="deleteData(<?= $product->productId ?>);">
                                                            <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                        </a>
                                                        <a class="mx-1" title="Product Photos List"
                                                            href="{{ route('product.productphotos', $product->productId) }}">
                                                            <i class="fa-solid fa-plus fa-lg"></i> Product Photos List
                                                        </a>
                                                        <a class="mx-1" title="Product Attribute"
                                                            href="{{ route('product.product_attribute', $product->productId) }}">
                                                            <i class="fa-solid fa-bars"></i> Product Attribute
                                                        </a>
                                                        <a class="mx-1" title="Inward"
                                                            href="{{ route('product.product_inward', $product->productId) }}">
                                                            <i class="fa fa-arrows-alt" aria-hidden="true"></i> Inward
    
                                                        </a>
                                                        <a class="mx-1" title="View Inward" href="#"
                                                            onclick="showDetailData(<?= $product->productId ?>)" data-bs-toggle="modal"
                                                            data-bs-target="#showModal">
                                                            <i class="fa-solid fa-eye"></i> View Inward
                                                        </a>
                                                        </div>
                                                    </td>
                                                
                                            </tr>
                                            <tr><td width="2%" colspan="5">.</td></tr>
                                            <?php $i++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $Product->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--Delete Modal -->
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
                            colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
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
                        <button type="button" class="btn w-sm btn-primary mx-2" data-bs-dismiss="modal">Close</button>
                        <form id="user-delete-form" method="POST"
                            action="{{ route('product.delete', $product->id ?? '') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="productId" id="deleteid" value="">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Modal -->
    
         
          <div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="btn-close"></button>

                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table shopping-summery table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Opening Balance</th>
                                    <th scope="col">Purchase</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Closing Balance</th>
                                </tr>
                            </thead>
                            <tbody clss="shopping-summery tbody">
                                
                            </tbody>
                        </table>        
                    <!--</div>-->
                        
                </div>
            </div>
        </div>
        <!--Edit Modal End -->

@endsection

@section('scripts')
    <script>
        function editpassword(id) {
            $("#GetId").val(id);
        }

        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>
    
     <script>
        function showDetailData(id) {
            var url = "{{ route('product.inwardData', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        id,
                        id
                    },
                    success: function(data) {
                        console.log("Success", data);
                         // Parse JSON response
                    var orders = JSON.parse(data);
                     try {
                    var orders = JSON.parse(data);       
                            // alert(orders);
                            // Build HTML content for order details
                            var html = '';
                            var serialNumber = 1; // Initialize total amount
                            orders.forEach(function(order) {
                                html += '<tr>';
                                 html += '<td>' + serialNumber + '</td>';
                                html += '<td class="text-center">' + order.Size + '</td>';
                                html += '<td class="text-center">' + order.openingBalance + '</td>';
                                html += '<td class="text-center">' + order.cr + '</td>';
                                html += '<td class="text-center">' + order.dr + '</td>';
                                html += '<td class="text-center">' + order.closingBalance + '</td>';
                                html += '</tr>';
                                serialNumber++;
                            });
                            // Update modal body with new HTML content
                            $('.shopping-summery tbody').html(html);
                                 } catch (error) {
                                console.error("Error parsing JSON", error);
                            }
                    },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error); // Log any AJAX errors
            }
                });
            }
        }
    </script>
@endsection
