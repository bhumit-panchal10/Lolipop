@extends('layouts.app')

@section('title', 'Add Showroom Report')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 offset-lg-2">

                        @include('common.alert')

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add Showroom Tracking</h4>
                            </div>

                            <div class="card-body">

                                <form action="{{ route('shoowroom.store') }}" method="POST">
                                    @csrf

                                    <div class="row">

                                        <!-- Customer Name -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" name="customer_name" class="form-control"
                                                placeholder="Enter Customer Name" required>
                                        </div>

                                        <!-- Mobile -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile</label>
                                            <input type="text" name="mobile" class="form-control"
                                                placeholder="Enter Mobile Number" required>
                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Enter Email">
                                        </div>

                                        <!-- Courier Dropdown -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Courier Name</label>
                                            <select name="courier_id" id="courierSelect" class="form-control" required>
                                                <option value="">Select Courier</option>
                                                @foreach ($couriers as $courier)
                                                    <option value="{{ $courier->id }}" data-url="{{ $courier->url }}">
                                                        {{ $courier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Docket No -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Docket Number</label>
                                            <input type="text" name="docketNo" class="form-control"
                                                placeholder="Enter Docket No" required>
                                        </div>

                                        <!-- Courier URL Auto-fill -->
                                        {{--  <div class="col-md-6 mb-3">
                                            <label class="form-label">Courier URL</label>
                                            <input type="text" id="courierUrl" name="courier_url" class="form-control"
                                                placeholder="Courier Tracking URL" readonly>
                                        </div>  --}}

                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary">Submit</button>
                                        <a href="{{ route('shoowroom.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>

                                </form>

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
        // Auto-fill courier URL when courier is selected
        $('#courierSelect').change(function() {
            let url = $(this).find(':selected').data('url');
            $('#courierUrl').val(url);
        });
    </script>
@endsection
