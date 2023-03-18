@extends('layouts.contentLayoutMaster')

@section('title', 'SerialNumbers')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@can('create-serialnumber')
@push('breadcrumb-right')
<x-buttons.primary text="create serialnumber" target="#addSerialNumberModal"  />
@endpush
@endcan

@section('content')

    <!-- SerialNumber Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
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
  <!--/ SerialNumber Table -->
@endsection

@push('modals')
    <!-- Add SerialNumber Modal -->
    <div class="modal fade" id="addSerialNumberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New SerialNumber</h1>
            </div>
            <form id="jquery-val-form" class="row" method="post" action="{{route('serialnumbers.store')}}">
                @csrf
                <div class="col-12">
                <label class="form-label" for="modalSerialNumberName">SerialNumber Name</label>
                <input
                    type="text"
                    id="modalSerialNumberName"
                    name="serialnumber"
                    class="form-control"
                    placeholder="SerialNumber Name"
                    autofocus
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
    <!--/ Add SerialNumber Modal -->
    
    <!-- Edit SerialNumber Modal -->
    <div class="modal fade" id="editSerialNumberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit SerialNumber</h1>
            </div>

    
            <form method="post" action="{{route('serialnumbers.update')}}" class="row">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="edit_id">
                <div class="col-12">
                    <label class="form-label" for="edit_serialnumber">SerialNumber Name</label>
                    <input
                        type="text"
                        id="edit_serialnumber"
                        name="serialnumber"
                        class="form-control"
                        placeholder="Enter a serial name"
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
    <!--/ Edit SerialNumber Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('serialnumbers.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#editSerialNumberModal').modal('show');
            $('#edit_serialnumber').val(name);
            $('#edit_id').val(id);
        });
    });
</script>
@endsection
