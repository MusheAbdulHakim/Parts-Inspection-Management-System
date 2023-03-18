@extends('layouts.contentLayoutMaster')

@section('title', 'Numeric Features')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@can('create-numberFeature')
@push('breadcrumb-right')
<x-buttons.primary text="Create Feature" target="#addNumericFeatureModal"  />
@endpush
@endcan

@section('content')

    <!-- NumericFeature Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Target</th>
                        <th>Upper Limit</th>
                        <th>Lower Limit</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ NumericFeature Table -->
@endsection

@push('modals')
    <!-- Add NumericFeature Modal -->
    <div class="modal fade" id="addNumericFeatureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Numeric Feature</h1>
            </div>
            <form class="row" method="post" action="{{route('number-features.store')}}">
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
                    <label class="form-label" for="target">Target</label>
                    <input
                        type="text"
                        id="target"
                        name="target"
                        class="form-control"
                        placeholder="Target"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="upper">Upper Limit</label>
                    <input
                        type="text"
                        id="upper"
                        name="upper_limit"
                        class="form-control"
                        placeholder="Upper Limit"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="lower">Lower Limit</label>
                    <input
                        type="text"
                        id="lower"
                        name="lower_limit"
                        class="form-control"
                        placeholder="Lower Limit"
                    />
                </div>
               
                <div class="col-12">
                    <label class="form-label" for="edit_description">Description</label>
                    <textarea name="description" class="form-control"
                    placeholder="Description" id="description" cols="3" rows="3"></textarea>
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
    <!--/ Add NumericFeature Modal -->
    
    <!-- Edit NumericFeature Modal -->
    <div class="modal fade" id="editNumericFeatureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Numeric Feature</h1>
            </div>

            <form method="post" action="{{route('number-features.update')}}" class="row">
                @csrf
                @method("PUT")
                <input type="hidden" name="id" id="edit_id">
                <div class="col-sm-12">
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
                    <label class="form-label" for="edit_target">Target</label>
                    <input
                        type="text"
                        id="edit_target"
                        name="target"
                        class="form-control"
                        placeholder="Target"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="edit_upper">Upper Limit</label>
                    <input
                        type="text"
                        id="edit_upper"
                        name="upper_limit"
                        class="form-control"
                        placeholder="Upper Limit"
                    />
                </div>

                <div class="col-12">
                    <label class="form-label" for="edit_lower">Lower Limit</label>
                    <input
                        type="text"
                        id="edit_lower"
                        name="lower_limit"
                        class="form-control"
                        placeholder="Lower Limit"
                    />
                </div>
                <div class="col-12">
                    <label class="form-label" for="edit_description">Description</label>
                    <textarea name="description" class="form-control"
                    placeholder="Description" id="edit_description" cols="3" rows="3"></textarea>
                </div>

                <div class="col-sm-3 ps-sm-0">
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </div>
                
            </form>
            </div>
        </div>
        </div>
    </div>
    <!--/ Edit NumericFeature Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('number-features.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'target', name: 'target'},
                {data: 'upper_limit', name: 'upper_limit'},
                {data: 'lower_limit', name: 'lower_limit'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var target = $(this).data('target');
            var upper = $(this).data('upper');
            var lower = $(this).data('lower');
            var desc = $(this).data('description');
            $('#editNumericFeatureModal').modal('show');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_target').val(target);
            $('#edit_upper').val(upper);
            $('#edit_lower').val(lower);
            $('#edit_description').val(desc);
        });
    });
</script>
@endsection
