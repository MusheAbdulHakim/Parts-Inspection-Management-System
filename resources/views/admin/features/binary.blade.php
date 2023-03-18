@extends('layouts.contentLayoutMaster')

@section('title', 'Binary Features')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{asset('summernote/summernote.min.css')}}">
@endsection

@can('create-binaryFeature')
@push('breadcrumb-right')
<x-buttons.primary text="Create Feature" target="#addBinaryFeatureModal"  />
@endpush
@endcan

@section('content')

    

    <!-- BinaryFeature Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Pass / Fail</th>
                        <th>Control Method</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ BinaryFeature Table -->


@endsection

@push('modals')
    <!-- Add BinaryFeature Modal -->
    <div class="modal fade" id="addBinaryFeatureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Binary Feature</h1>
            </div>
            <form class="row" method="post" action="{{route('binary-features.store')}}">
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
                    <label for="bool" class="form-label">Pass / Fail</label>
                    <select name="bool" id="bool" class="form-control select2">
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>
                
                <div class="col-12">
                    <label class="form-label" for="description">Control Method</label>
                    <textarea name="description" class="form-control summernote"
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
    <!--/ Add BinaryFeature Modal -->
    
    <!-- Edit BinaryFeature Modal -->
    <div class="modal fade" id="editBinaryFeatureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Binary Feature</h1>
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
                    <label for="edit_bool" class="form-label">Pass / Fail</label>
                    <select name="bool" id="edit_bool" class="form-control select2">
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>
                
               
                <div class="col-12">
                    <label class="form-label" for="edit_description">Control Method</label>
                    <textarea name="description" class="form-control summernote"
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
    <!--/ Edit BinaryFeature Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{asset('summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.summernote').summernote();
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('binary-features.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'bool', name: 'bool'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var url = "{{route('binary-features.index')}}/"+id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(e){
                    if($.trim(e)){
                        $('#editBinaryFeatureModal').modal('show');
                        $('#edit_id').val(e.id);
                        $('#edit_name').val(e.name);
                        $('#edit_bool').val(e.bool).trigger('change');
                        $('#edit_description').summernote('code',e.description);
                    }
                }
            });
        });
    });
</script>
@endsection
