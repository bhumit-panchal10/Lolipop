@extends('layouts.app')

@section('title', 'Testimonials - Lolipop Kindswear')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    Testimonials List
                                </h5>
                            </div>

                            <div class="card-body">

                                {{-- Top Actions --}}
                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    {{-- Bulk Delete --}}
                                    <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn">

                                        <i class="fas fa-trash"></i>
                                        Delete Selected
                                    </button>

                                    {{-- Add Testimonial --}}
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addTestimonialModal">

                                        <i class="fas fa-plus"></i>
                                        Add Testimonial
                                    </button>

                                </div>


                                {{-- Listing --}}
                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped align-middle">

                                        <thead>
                                            <tr>

                                                <th width="40">
                                                    <input type="checkbox" id="selectAll">
                                                </th>

                                                <th>Name</th>

                                                <th>Tag</th>

                                                <th>Description</th>

                                                <th width="100" class="text-center">
                                                    Action
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse($testimonials as $testimonial)
                                                <tr>

                                                    <td>
                                                        <input type="checkbox" class="testimonialCheckbox"
                                                            value="{{ $testimonial->id }}">
                                                    </td>

                                                    <td>
                                                        {{ $testimonial->name }}
                                                    </td>

                                                    <td>
                                                        {{ $testimonial->tag }}
                                                    </td>

                                                    <td>
                                                        {{ $testimonial->description }}
                                                    </td>

                                                    <td class="text-center">

                                                        {{-- Edit --}}
                                                        <a href="javascript:void(0)" class="text-primary editTestimonial"
                                                            data-id="{{ $testimonial->id }}"
                                                            data-name="{{ $testimonial->name }}"
                                                            data-tag="{{ $testimonial->tag }}"
                                                            data-description="{{ $testimonial->description }}"
                                                            title="Edit">

                                                            <i class="fas fa-edit"></i>

                                                        </a>

                                                        &nbsp;&nbsp;

                                                        {{-- Delete --}}
                                                        <a href="javascript:void(0)" class="text-danger deleteTestimonial"
                                                            data-id="{{ $testimonial->id }}" title="Delete">

                                                            <i class="fas fa-trash"></i>

                                                        </a>

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No testimonials found.
                                                    </td>
                                                </tr>
                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>


                                {{-- Pagination --}}
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $testimonials->links() }}
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- =========================================================
    ADD TESTIMONIAL MODAL
========================================================= --}}
    <div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Add Testimonial
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <form action="{{ route('testimonial.store') }}" method="POST">

                    @csrf

                    <div class="modal-body">

                        {{-- Name --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Name
                                <span style="color:red;">*</span>
                            </label>

                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter Name" required>

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif

                        </div>


                        {{-- Tag --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Tag
                            </label>

                            <input type="text" name="tag" class="form-control" value="{{ old('tag') }}"
                                placeholder="Enter Tag">

                            @if ($errors->has('tag'))
                                <span class="text-danger">
                                    {{ $errors->first('tag') }}
                                </span>
                            @endif

                        </div>


                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description" class="form-control" rows="5" placeholder="Enter Description">{{ old('description') }}</textarea>

                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save"></i>
                            Save

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>



    {{-- =========================================================
    EDIT TESTIMONIAL MODAL
========================================================= --}}
    <div class="modal fade" id="editTestimonialModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Testimonial
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>


                <form method="POST" id="editTestimonialForm">

                    @csrf

                    <div class="modal-body">


                        {{-- Name --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Name
                                <span style="color:red;">*</span>
                            </label>

                            <input type="text" name="name" id="edit_name" class="form-control"
                                placeholder="Enter Name" required>

                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif

                        </div>


                        {{-- Tag --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Tag
                            </label>

                            <input type="text" name="tag" id="edit_tag" class="form-control"
                                placeholder="Enter Tag">

                            @if ($errors->has('tag'))
                                <span class="text-danger">
                                    {{ $errors->first('tag') }}
                                </span>
                            @endif

                        </div>


                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description" id="edit_description" class="form-control" rows="5"
                                placeholder="Enter Description"></textarea>

                            @if ($errors->has('description'))
                                <span class="text-danger">
                                    {{ $errors->first('description') }}
                                </span>
                            @endif

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

                $('.testimonialCheckbox').prop(
                    'checked',
                    $(this).prop('checked')
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Individual Checkbox
            |--------------------------------------------------------------------------
            */
            $(document).on('change', '.testimonialCheckbox', function() {

                let total = $('.testimonialCheckbox').length;

                let checked = $('.testimonialCheckbox:checked').length;

                $('#selectAll').prop(
                    'checked',
                    total === checked
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Edit Testimonial
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '.editTestimonial', function() {

                let id = $(this).data('id');
                let name = $(this).data('name');
                let tag = $(this).data('tag');
                let description = $(this).data('description');

                $('#edit_name').val(name);
                $('#edit_tag').val(tag);
                $('#edit_description').val(description);

                let updateUrl =
                    "{{ route('testimonial.update', ':id') }}";

                updateUrl = updateUrl.replace(':id', id);

                $('#editTestimonialForm').attr(
                    'action',
                    updateUrl
                );

                $('#editTestimonialModal').modal('show');

            });


            /*
            |--------------------------------------------------------------------------
            | Single Delete
            |--------------------------------------------------------------------------
            */
            $(document).on('click', '.deleteTestimonial', function() {

                let id = $(this).data('id');

                if (
                    !confirm(
                        'Are you sure you want to delete this testimonial?'
                    )
                ) {
                    return;
                }

                let deleteUrl =
                    "{{ route('testimonial.destroy', ':id') }}";

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

                        alert(
                            'Something went wrong while deleting the testimonial.'
                        );

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

                $('.testimonialCheckbox:checked').each(function() {

                    ids.push($(this).val());

                });


                if (ids.length === 0) {

                    alert(
                        'Please select at least one testimonial.'
                    );

                    return;
                }


                if (
                    !confirm(
                        'Are you sure you want to delete selected testimonials?'
                    )
                ) {
                    return;
                }


                $.ajax({

                    url: "{{ route('testimonial.bulk-delete') }}",

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

                            alert(
                                'Something went wrong while deleting selected testimonials.'
                            );

                        }

                    }

                });

            });

        });
    </script>

@endsection
