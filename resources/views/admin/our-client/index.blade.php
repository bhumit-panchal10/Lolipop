@extends('layouts.app')

@section('title', 'Our Clients - Lolipop Kindswear')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">

                    {{-- ================= ADD CLIENT LEFT SIDE ================= --}}
                    <div class="col-lg-4">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title mb-0">Add Client</h5>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('our-client.store') }}" method="POST" enctype="multipart/form-data">

                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Client Name
                                        </label>

                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Enter Client Name">

                                        @if ($errors->has('name'))
                                            <span class="text-danger">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Client Image
                                            <span style="color:red;">*</span>
                                        </label>

                                        <input type="file" name="image" class="form-control" accept="image/*" required>

                                        @if ($errors->has('image'))
                                            <span class="text-danger">
                                                {{ $errors->first('image') }}
                                            </span>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>
                                        Save
                                    </button>

                                </form>

                            </div>
                        </div>
                    </div>


                    {{-- ================= LISTING RIGHT SIDE ================= --}}
                    <div class="col-lg-8">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    Our Clients List
                                </h5>
                            </div>

                            <div class="card-body">

                                {{-- Bulk Delete --}}
                                <div class="mb-3">
                                    <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn">
                                        <i class="fas fa-trash"></i>
                                        Delete Selected
                                    </button>
                                </div>

                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped align-middle">

                                        <thead>
                                            <tr>
                                                <th width="40">
                                                    <input type="checkbox" id="selectAll">
                                                </th>

                                                <th>Name</th>

                                                <th width="120">Image</th>

                                                <th width="100" class="text-center">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse($clients as $client)
                                                <tr>

                                                    <td>
                                                        <input type="checkbox" class="clientCheckbox"
                                                            value="{{ $client->id }}">
                                                    </td>

                                                    <td>
                                                        {{ $client->name }}
                                                    </td>

                                                    <td>
                                                        @if ($client->image)
                                                            <img src="{{ asset('uploads/clients/' . $client->image) }}"
                                                                alt="{{ $client->name }}"
                                                                style="width:80px;height:60px;object-fit:contain;">
                                                        @endif
                                                    </td>

                                                    <td class="text-center">

                                                        {{-- Edit Icon --}}
                                                        <a href="javascript:void(0)" class="text-primary editClient"
                                                            data-id="{{ $client->id }}" data-name="{{ $client->name }}"
                                                            data-image="{{ asset('uploads/clients/' . $client->image) }}"
                                                            title="Edit">

                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        &nbsp;&nbsp;

                                                        {{-- Delete Icon --}}
                                                        <a href="javascript:void(0)" class="text-danger deleteClient"
                                                            data-id="{{ $client->id }}" title="Delete">

                                                            <i class="fas fa-trash"></i>
                                                        </a>

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        No clients found.
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>

                                    </table>

                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $clients->links() }}
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- =========================================================
    EDIT CLIENT MODAL
========================================================= --}}
    <div class="modal fade" id="editClientModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Edit Client
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <form method="POST" id="editClientForm" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Client Name
                            </label>

                            <input type="text" name="name" id="edit_name" class="form-control">

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Client Image
                            </label>

                            <input type="file" name="image" class="form-control" accept="image/*">

                            @if ($errors->has('image'))
                                <span class="text-danger">
                                    {{ $errors->first('image') }}
                                </span>
                            @endif

                        </div>

                        <div class="mb-3">
                            <img src="" id="edit_image_preview"
                                style="max-width:150px;max-height:100px;object-fit:contain;">
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Update
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection


@section('scripts')

    <script>
        $(document).ready(function() {

            /*
            |--------------------------------------------------------------------------
            | Select All
            |--------------------------------------------------------------------------
            */
            $('#selectAll').on('change', function() {

                $('.clientCheckbox').prop(
                    'checked',
                    $(this).prop('checked')
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Individual Checkbox
            |--------------------------------------------------------------------------
            */
            $(document).on('change', '.clientCheckbox', function() {

                let total = $('.clientCheckbox').length;
                let checked = $('.clientCheckbox:checked').length;

                $('#selectAll').prop(
                    'checked',
                    total === checked
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Edit Client
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '.editClient', function() {

                let id = $(this).data('id');
                let name = $(this).data('name');
                let image = $(this).data('image');

                $('#edit_name').val(name);
                $('#edit_image_preview').attr('src', image);

                let updateUrl = "{{ route('our-client.update', ':id') }}";

                updateUrl = updateUrl.replace(':id', id);

                $('#editClientForm').attr(
                    'action',
                    updateUrl
                );

                $('#editClientModal').modal('show');

            });


            /*
            |--------------------------------------------------------------------------
            | Single Delete
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '.deleteClient', function() {

                let id = $(this).data('id');

                if (!confirm('Are you sure you want to delete this client?')) {
                    return;
                }

                let deleteUrl = "{{ route('our-client.destroy', ':id') }}";

                deleteUrl = deleteUrl.replace(':id', id);

                $.ajax({

                    url: deleteUrl,

                    type: 'DELETE',

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        alert(response.message);

                        location.reload();
                    },

                    error: function() {

                        alert('Something went wrong while deleting the client.');
                    }

                });

            });


            /*
            |--------------------------------------------------------------------------
            | Bulk Delete
            |--------------------------------------------------------------------------
            */
            $('#bulkDeleteBtn').on('click', function() {

                let ids = [];

                $('.clientCheckbox:checked').each(function() {
                    ids.push($(this).val());
                });

                if (ids.length === 0) {

                    alert('Please select at least one client.');

                    return;
                }

                if (!confirm('Are you sure you want to delete selected clients?')) {
                    return;
                }

                $.ajax({

                    url: "{{ route('our-client.bulk-delete') }}",

                    type: 'POST',

                    data: {
                        _token: "{{ csrf_token() }}",
                        ids: ids
                    },

                    success: function(response) {

                        alert(response.message);

                        location.reload();
                    },

                    error: function(xhr) {

                        if (
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('Something went wrong while deleting selected clients.');
                        }
                    }

                });

            });

        });
    </script>

@endsection
