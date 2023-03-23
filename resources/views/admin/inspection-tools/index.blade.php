@extends('layouts.contentLayoutMaster')

@section('title', 'Inspection Tools')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{asset('summernote/summernote.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection

@can('create-inspectionTool')
@push('breadcrumb-right')
<x-buttons.primary text="create Inspection Tool" target="#addInspectionToolModal"  />
@endpush
@endcan

@section('content')

    <!-- InspectionTool Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Calibration</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ InspectionTool Table -->
@endsection

@push('modals')
    <!-- Add InspectionTool Modal -->
    <div class="modal fade" id="addInspectionToolModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Inspection Tool</h1>
            </div>
            <form class="row" method="post" action="{{route('inspection-tools.store')}}">
                @csrf
                <div class="mb-1">
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
                </div>
                <div class="col-12">
                    <div class="choose-position">
                        <select data-placeholder="Select Calibration" name="calibration" id="calibration" class="form-control position-select">
                            <option value=""></option>
                            @foreach ($calibrations as $calibration)
                                <option value="{{$calibration->id}}">{{$calibration->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
               
               <div class="mb-1">
                <div class="col-12">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" class="form-control summernote"
                    placeholder="Description" id="description" cols="3" rows="3"></textarea>
                </div>
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
    <!--/ Add InspectionTool Modal -->
    
    <!-- Edit InspectionTool Modal -->
    <div class="modal fade" id="editInspectionToolModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Inspection Tool</h1>
            </div>

            <form method="post" action="{{route('inspection-tools.update')}}" class="row">
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
                <div class="mb-1">
                    <div class="col-12">
                        <div class="choose-position">
                            <select data-placeholder="Select Calibration" name="calibration" id="edit_calibration" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($calibrations as $calibration)
                                    <option value="{{$calibration->id}}">{{$calibration->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label" for="edit_description">Description</label>
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
    <!--/ Edit InspectionTool Modal -->
@endpush

@section('page-script')
<script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>
<script src="{{asset('summernote/summernote.min.js')}}"></script>
<script>
    $(document).ready(function(){
        if($('.position-select').length > 0){
            $(".position-select").each((_i, e) => {
                var $e = $(e);
                $e.select2({
                    width: '100%',
                    tags: true,
                    dropdownParent: $e.parent()
                });
            });
        }
        $('.summernote').summernote();
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('inspection-tools.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'calibration', name: 'calibration'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var url = "{{route('inspection-tools.index')}}/"+id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(e){
                    if($.trim(e)){
                        $('#editInspectionToolModal').modal('show');
                        $('#edit_id').val(e.id);
                        $('#edit_name').val(e.name);
                        $('#edit_calibration').val(e.calibration_id).trigger('change');
                        $('#edit_description').summernote('code',e.description);
                    }
                }
            });
        });
    });
</script>
@endsection
