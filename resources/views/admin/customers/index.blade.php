@extends('layouts.contentLayoutMaster')

@section('title', 'Customers')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@can('create-customer')
@push('breadcrumb-right')
<x-buttons.primary text="create Customer" target="#addCustomerModal"  />
@endpush
@endcan

@section('content')

    <!-- Customer Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ Customers Table -->
@endsection

@push('modals')
    <!-- Add Customers Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Customer</h1>
            </div>
            <form class="row" method="post" action="{{route('customers.store')}}">
                @csrf
                <div class="col-12">
                    <label class="form-label" for="name">Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Name"
                    />
                </div>
                <div class="col-12">
                    <label class="form-label" for="email">Email</label>
                    <input
                        type="text"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="phone">Phone</label>
                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        class="form-control"
                        placeholder="Phone"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="address">Address</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        class="form-control"
                        placeholder="Address"
                    />
                </div>
                
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-2 me-1">Create</button>
                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    <!--/ Add Customer Modal -->
    
    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Customer</h1>
            </div>

            <form method="post" action="{{route('customers.update')}}" class="row">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="edit_id">
                <div class="col-sm-9">
                    <label class="form-label" for="edit_name">Name</label>
                    <input
                        type="text"
                        id="edit_name"
                        name="name"
                        class="form-control"
                        placeholder="Name"
                        required
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="edit_email">Email</label>
                    <input
                        type="text"
                        id="edit_email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="edit_phone">Phone</label>
                    <input
                        type="text"
                        id="edit_phone"
                        name="phone"
                        class="form-control"
                        placeholder="Phone"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="edit_address">Address</label>
                    <input
                        type="text"
                        id="edit_address"
                        name="address"
                        class="form-control"
                        placeholder="Address"
                    />
                </div>

                <div class="col-sm-3 ps-sm-0">
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </div>
                
            </form>
            </div>
        </div>
        </div>
    </div>
    <!--/ Edit Customer Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('customers.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var address = $(this).data('address');
            $('#editCustomerModal').modal('show');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            $('#edit_address').val(address);
        });
    });
</script>
@endsection
