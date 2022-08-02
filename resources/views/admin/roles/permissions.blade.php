@extends('layouts.contentLayoutMaster')

@section('title', 'Permission')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@push('breadcrumb-right')
@can('create-permission')
<x-buttons.primary text="create permission" target="#addPermissionModal"  />
@endcan
@endpush

@section('content')

    <!-- Permission Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="datatables-permissions table">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ Permission Table -->
@endsection

@push('modals')
    <!-- Add Permission Modal -->
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Permission</h1>
                <p>Permissions you may use and assign to your users.</p>
            </div>
            <form id="jquery-val-form" class="row" method="post" action="{{route('permissions.store')}}">
                @csrf
                <div class="col-12">
                <label class="form-label" for="modalPermissionName">Permission Name</label>
                <input
                    type="text"
                    id="modalPermissionName"
                    name="permission"
                    class="form-control"
                    placeholder="Permission Name"
                    autofocus
                    data-msg="Please enter permission name"
                />
                </div>
                
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary mt-2 me-1">Create Permission</button>
                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                        Discard
                    </button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
    <!--/ Add Permission Modal -->
    
    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Permission</h1>
                <p>Edit permission as per your requirements.</p>
            </div>
    
            <div class="alert alert-warning" role="alert">
                <h6 class="alert-heading">Warning!</h6>
                <div class="alert-body">
                By editing the permission name, you might break the system permissions functionality. Please ensure you're
                absolutely certain before proceeding.
                </div>
            </div>
    
            <form method="post" action="{{route('permissions.update')}}" class="row">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="edit_id">
                <div class="col-sm-9">
                    <label class="form-label" for="edit_permission">Permission Name</label>
                    <input
                        type="text"
                        id="edit_permission"
                        name="permission"
                        class="form-control"
                        placeholder="Enter a permission name"
                        tabindex="-1"
                        data-msg="Please enter permission name"
                        required
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
    <!--/ Edit Permission Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('permissions.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#editPermissionModal').modal('show');
            $('#edit_permission').val(name);
            $('#edit_id').val(id);
        });
    });
</script>
@endsection
