@extends('layouts.app')
@section('title', 'Banner List')
@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-5">

                                        <div class="d-flex justify-content-between card-header">
                                            <h5 class="card-title mb-0">Add Banner </h5>
                                        </div>

                                        <div class="live-preview">
                                            <form method="POST" action="{{ route('banner.store') }}"
                                                onsubmit="return validateFile()" autocomplete="off"
                                                enctype="multipart/form-data">
                                                @csrf

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <span style="color:red;">*</span>Photo
                                                        <input type="file" class="form-control" name="strPhoto"
                                                            id="strPhoto" autocomplete="off" required autofocus>
                                                        <div id="viewimg">
                                                            @error('photo')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary mx-2"
                                                            id="add-btn">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="d-flex justify-content-between card-header">
                                            <h5 class="card-title mb-0">Banner List</h5>
                                        </div>

                                        <table id="scroll-horizontal" class="table nowrap align-middle mt-3"
                                            style="width:100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Photo</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($datas as $data)
                                                    <tr class="text-center">
                                                        <td>{{ $i + $datas->perPage() * ($datas->currentPage() - 1) }}
                                                        </td>
                                                        <td>
                                                            <a href="http://127.0.0.1:8000/Banner/<?php echo $data->strPhoto; ?>"
                                                                target="_blank" class="mx-1">
                                                                <img src="{{ asset('Banner/') . '/' . $data->strPhoto }}"
                                                                    alt="" width="50px" height="50px">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <div class="gap-2">
                                                                <a class="mx-1" href="#" data-bs-toggle="modal"
                                                                    title="Delete" data-bs-target="#deleteRecordModal"
                                                                    onclick="deleteData(<?= $data->bannerId ?>);">
                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                                </a>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="d-flex justify-content-center mt-3">
                                            {{ $datas->links() }}
                                        </div>
                                    </div>

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
                                    <form id="user-delete-form" method="POST" action="{{ route('banner.delete') }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="bannerId" id="deleteid" value="">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Delete modal End -->

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

            for (var index in allowedExtension) {

                if (fileExtension === allowedExtension[index]) {
                    isValidFile = true;
                    break;
                }
            }
            if (!isValidFile) {
                alert('Allowed Extensions are : *.' + allowedExtension.join(', *.'));
            }
            return isValidFile;
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
    </script>

    <script>
        function deleteData(id) {
            $("#deleteid").val(id);
        }
    </script>

@endsection
