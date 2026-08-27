@extends('layouts.app')

@section('title', 'Showroom Orders')

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
                                <h5 class="card-title mb-0">Showroom Order Tracking</h5>
                            </div>

                            <div class="card-body">

                                <!-- Search Form -->
                                <div class="container-fluid">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="GET" id="form" action="{{ route('shoowroom.index') }}">
                                                @csrf
                                                <div class="row align-items-center">

                                                    <div class="col-md-3 mb-2">
                                                        <input type="text" class="form-control" name="name"
                                                            placeholder="Enter Customer Name" value="{{ $name ?? '' }}">
                                                    </div>

                                                    <div class="col-md-3 mb-2">
                                                        <input type="text" class="form-control" name="mobile"
                                                            placeholder="Enter Mobile" value="{{ $mobile ?? '' }}">
                                                    </div>

                                                    <div class="col-md-3 mb-2">
                                                        <input type="text" class="form-control" name="email"
                                                            placeholder="Enter Email" value="{{ $email ?? '' }}">
                                                    </div>

                                                    <div class="col-md-3 mb-2">
                                                        <div class="input-group">
                                                            <button type="submit"
                                                                class="btn btn-primary mx-2">Search</button>
                                                            <a href="{{ route('shoowroom.index') }}"
                                                                class="btn btn-secondary mx-2">Cancel</a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Table Listin -->
                                <div class="tab-content text-muted mt-3">
                                    <div class="tab-pane active">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">

                                                        <div class="table-responsive">
                                                            <table class="table nowrap align-middle" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sr.No</th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Mobile</th>
                                                                        <th>Courier Name</th>
                                                                        <th>Docket No</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    @php $i = 1; @endphp

                                                                    @foreach ($ShowroomOrders as $order)
                                                                        <tr class="text-center">
                                                                            <td>
                                                                                {{ $i + $ShowroomOrders->perPage() * ($ShowroomOrders->currentPage() - 1) }}
                                                                            </td>

                                                                            <td>{{ $order->customer_name }}</td>
                                                                            <td>{{ $order->email }}</td>
                                                                            <td>{{ $order->mobile }}</td>

                                                                            <td>
                                                                                @if (!empty($order->courier_url))
                                                                                    <a target="_blank"
                                                                                        href="{{ $order->courier_url }}{{ $order->docketNo }}">
                                                                                        {{ $order->courier_name }}
                                                                                    </a>
                                                                                @else
                                                                                    {{ $order->courier_name ?? '-' }}
                                                                                @endif
                                                                            </td>

                                                                            <td>{{ $order->docketNo }}</td>
                                                                            <td>
                                                                                <a href="{{ route('shoowroom.resend', $order->id) }}"
                                                                                    style="color:#000; text-decoration:underline;"
                                                                                    onclick="return confirm('Resend SMS, WhatsApp & Email?')">
                                                                                    🔄 Resend Link
                                                                                </a>
                                                                                <!-- Edit -->
                                                                                <a href="javascript:void(0)"
                                                                                   class="text-primary me-2"
                                                                                   title="Edit"
                                                                                   onclick="openEditModal({{ $order->id }})">
                                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                                </a>
                                                                                
                                                                                <!-- Delete -->
                                                                                <form action="{{ route('shoowroom.destroy', $order->id) }}"
                                                                                      method="POST"
                                                                                      style="display:inline;"
                                                                                      onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                
                                                                                    <button type="submit"
                                                                                            class="btn btn-link text-danger p-0"
                                                                                            title="Delete">
                                                                                        <i class="fa-solid fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </td>

                                                                        </tr>
                                                                        @php $i++; @endphp
                                                                    @endforeach

                                                                </tbody>
                                                            </table>

                                                            <div class="d-flex justify-content-center mt-3">
                                                                {{ $ShowroomOrders->appends(request()->except('page'))->links() }}
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div> <!-- card-body -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<!-- Edit Showroom Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form id="editForm" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Showroom Tracking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Customer Name</label>
                                <input type="text" name="customer_name" id="edit_customer_name" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Mobile</label>
                                <input type="text"
                                       name="mobile"
                                       id="edit_mobile"
                                       class="form-control"
                                       required
                                       maxlength="10"
                                       pattern="[0-9]{10}"
                                       inputmode="numeric"
                                       placeholder="Enter 10-digit mobile number"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                            </div>


                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Courier</label>
                                <select name="courier_id" id="edit_courier_id" class="form-control" required>
                                    @foreach ($couriers as $courier)
                                        <option value="{{ $courier->id }}">
                                            {{ $courier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Docket No</label>
                                <input type="text" name="docketNo" id="edit_docketNo" class="form-control" required>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        function openEditModal(id) {
            $.get("{{ url('admin/shoowroom') }}/" + id + "/edit", function(data) {

                $('#edit_customer_name').val(data.customer_name);
                $('#edit_mobile').val(data.mobile);
                $('#edit_email').val(data.email);
                $('#edit_courier_id').val(data.courier_id);
                $('#edit_docketNo').val(data.docketNo);

                $('#editForm').attr('action', "{{ url('admin/shoowroom') }}/" + id + "/update");

                $('#editModal').modal('show');
            });
        }
    </script>

@endsection