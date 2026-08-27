@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit Product</h4>
                            <div class="page-title-right">
                                <a href="{{ route('product.index') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="live-preview">
                                    <form id="regForm" method="POST" onsubmit="return validateFile()"
                                        action="{{ route('product.update', $product->productId) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row gy-4">

                                            <?php
                                            {{--  $stdArr = [];
                                            foreach ($CategoryMultiple as $category) {
                                                $stdArr[] = $category->categoryid;
                                            }  --}}
                                            ?>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Category
                                                    <select class="form-control" onchange="validatecategory();"
                                                        name="categoryId" id="categoryId" required>
                                                        <option value="">Select Category Name
                                                        </option>
                                                        @foreach ($Category as $category)
                                                            <option value="{{ $category->categoryId }}"
                                                                {{ $product->categoryId == $category->categoryId ? 'selected' : '' }}>
                                                                {{ $category->categoryname }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('categoryId')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!--<input type="hidden" name="subcategory" id="subcategory"-->
                                            <!--    value="{{ $product->subcategoryid }}">-->


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Sub Category
                                                    <select class="form-control" name="subcategoryid" id="subcategoryid">
                                                        <option value="" selected>Select Sub Category
                                                        </option>
                                                        @foreach ($SubCategory as $sub)
                                                            <option value="{{ $sub->subcategoryid }}"
                                                                {{ $product->categoryId == $sub->subcategoryid ? 'selected' : '' }}>
                                                                {{ $sub->categoryname }}
                                                            </option>
                                                        @endforeach    
                                                    </select>
                                                    @error('subcategoryid')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Product Name
                                                    <input type="text" class="form-control" placeholder="Enter  Name"
                                                        name="productname" autocomplete="off"
                                                        value="{{ $product->productname }}" required>
                                                    @error('productname')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                            <?php
                                            $ProductImages = \App\Models\Productphotos::select('productphotosid', 'strphoto')
                                                ->where(['productphotos.iStatus' => 1, 'productphotos.isDelete' => 0, 'productid' => $product->productId])
                                                ->get();
                                            $arr = [];
                                            foreach ($ProductImages as $value) {
                                                $arr[] = $value->strphoto;
                                            }
                                            ?>


                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Multiple Photo (Upto 5)
                                                    <input type="file" name="photo[]" multiple class="form-control"
                                                        id="Editphoto">
                                                    {{--  <input type="hidden" name="hiddenPhoto" class="form-control"
                                                        value="{{ old('photo') ? old('photo') : $product->photo }}"
                                                        id="hiddenPhoto">  --}}

                                                    <div class="d-flex justify-content-between mt-3 mb-3">
                                                        @foreach ($ProductImages as $ProductImage)
                                                            <?php if (in_array($ProductImage->strphoto, $arr)){ ?>
                                                            <div id="PHOTOID_<?= $ProductImage->productphotosid ?>">
                                                                <img src="/Product/Thumbnail/{{ $ProductImage->strphoto }}"
                                                                    width="50px" height="50px">

                                                                <button type="button"
                                                                    onclick="imagedelete(<?= $ProductImage->productphotosid ?>);"
                                                                    class="btn btn-link p-0">
                                                                    <span class="text-500 fas fa-trash-alt"></span>
                                                                </button>

                                                            </div> &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <?php }?>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Fabric
                                                    <input type="text" class="form-control" name="fabric" 
                                                        id="fabric"  value="{{ $product->fabric }}">
                                                    @error('fabric')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Care
                                                    <input type="text" class="form-control" name="care" 
                                                        id="care"  value="{{ $product->care }}">
                                                    @error('care')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-4 col-md-6">
                                                <div>
                                                    <span style="color:red;">*</span>Disclaimer
                                                    <input type="text" class="form-control" name="disclaimer" 
                                                        id="disclaimer"  value="{{ $product->disclaimer }}">
                                                    @error('disclaimer')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6">
                                                <div class="mt-4">
                                                    <input type="checkbox" name="isFeatures" id="isFeatures"
                                                        {{ $product->isFeatures == 1 ? 'checked' : null }}>
                                                    Is Trending

                                                </div>
                                            </div>




                                            <div class="col-lg-12 col-md-6">
                                                <span style="color:red;"></span>Description</label>
                                                <textarea class="form-control ckeditor" name="description" id="description" rows="6">{{ $product->description }}</textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Title</label>
                                                <textarea class="form-control" name="meta_title" id="meta_title" rows="6">
                                                    {{ $product->meta_title }}
                                                </textarea>

                                            </div>

                                            <div class="col-lg-6 col-md-6">
                                                <span style="color:red;"></span>Meta Description</label>
                                                <textarea class="form-control" name="meta_description" id="meta_description" rows="6">{{ $product->meta_description }}</textarea>
                                            </div>

                                        </div>
                                        <div class="card-footer mt-5" style="float: right;">
                                            <button type="submit"
                                                class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                                            <a class="btn btn-primary float-right mr-3 mb-3 mx-2"
                                                href="{{ route('product.edit', $product->productId) }}">Cancel</a>
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


@endsection

@section('scripts')

    <script>
        function validateFile() {
            var allowedExtension = ['jpeg', 'jpg', 'png', 'webp'];
            var fileExtension = document.getElementById('strPhoto').value.split('.').pop().toLowerCase();
            var isValidFile = false;
            var image = document.getElementById('strPhoto').value;

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (image != "") {
                if (!isValidFile) {
                    alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
                }
                return isValidFile;
            }

            return true;
        }
    </script>



    {{-- Add photo --}}
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#hello').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#strPhoto").change(function() {
            html =
                '<img src="' + readURL(this) +
                '"   id="hello" width="70px" height = "70px" > ';
            $('#viewimg').html(html);
        });
        
        $(document).ready(function() {
            $('#regForm').on('submit', function () {
                // Disable the submit button to prevent multiple submissions
                $(this).find(':submit').prop('disabled', true);
            });
        });
    </script>

    <script>
        function imagedelete(id) {
            var url = "{{ route('product.imagedelete', ':id') }}";
            url = url.replace(":id", id);
            if (id) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        id: id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        console.log(data);
                        var obj = JSON.parse(data);
                        $("#PHOTOID_" + id).html("");
                    }
                });
            }
        }
    </script>

    <script>
        function validatecategory() {
            var Category = $('#categoryId').val();
            var url = "{{ route('product.getEditsubcategory') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    Category,
                    Category
                },
                success: function(data) {
                    console.log(data);
                    $("#subcategoryid").html(data);
                }
            });
        }
    </script>


@endsection
