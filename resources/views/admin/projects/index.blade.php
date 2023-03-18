@extends('layouts.contentLayoutMaster')

@section('title', 'Projects')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@can('create-projects')
@push('breadcrumb-right')
<x-buttons.primary text="create project" target="#addProjectModal"  />
@endpush
@endcan

@section('content')

    <!-- Projects Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Customer</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ Projects Table -->
@endsection

@push('modals')
    <!-- Add Project Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Project</h1>
            </div>
            <form class="row" method="post" action="{{route('projects.store')}}">
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
                    <label class="form-label" for="customer">Customer</label>
                    <input
                        type="text"
                        id="customer"
                        name="customer"
                        class="form-control"
                        placeholder="Customer"
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
    <!--/ Add Project Modal -->
    
    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Project</h1>
            </div>

            <form method="post" action="{{route('projects.update')}}" class="row">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="edit_id">
                <div class="col-12">
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
                    <label class="form-label" for="edit_customer">Customer</label>
                    <input
                        type="text"
                        id="edit_customer"
                        name="customer"
                        class="form-control"
                        placeholder="Customer"
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
    <!--/ Edit Project Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('projects.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'customer', name: 'customer'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var customer = $(this).data('customer');
            $('#editProjectModal').modal('show');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_customer').val(customer);
        });
    });
</script>
@endsection
