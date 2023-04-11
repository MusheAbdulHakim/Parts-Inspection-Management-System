@extends('layouts.contentLayoutMaster')

@section('title', 'Control Plans')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection

@can('create-controlPlan')
@push('breadcrumb-right')
<x-buttons.primary text="Create Contro Plan" target="#addControlPlanModal"  />
@endpush
@endcan

@section('content')

    <!-- ControlPlan Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="table table-bordered dt-responsive">
                    <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Feature</th>
                        <th>Work Instruction</th>
                        <th>Created Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ ControlPlan Table -->


@endsection

@push('modals')
    <!-- Add BinaryFeature Modal -->
    <div class="modal fade" id="addControlPlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 pb-5">
            <div class="text-center mb-2">
                <h1 class="mb-1">Add New Control Plan</h1>
            </div>
            <form class="row" method="post" action="{{route('control-plans.store')}}">
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

                <div class="mb-1">
                    <div class="col-12">
                        <label for="feature" class="form-label">Features</label>
                        <div class="choose-position">
                            <select data-placeholder="Select Feature" multiple name="feature[]" id="feature" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($features as $feature)
                                    <option value="{{$feature->id}}">{{$feature->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="mb-1">
                    <div class="col-12">
                        <label for="work" class="form-label">Work Instructions</label>
                        <div class="choose-position">
                            <select data-placeholder="Select Work Instruction" name="work" id="work" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($work_instructions as $instruction)
                                    <option value="{{$instruction->id}}">{{$instruction->name}}</option>
                                @endforeach
                            </select>
                        </div>
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
    <!--/ Add ControlPlan Modal -->

    <!-- Edit ControlPlan Modal -->
    <div class="modal fade" id="editControlPlanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Control Plan</h1>
            </div>

            <form method="post" action="{{route('control-plans.update')}}" class="row">
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

                <div class="mb-1">
                    <div class="col-12">
                        <label for="edit_feature" class="form-label">Features</label>
                        <div class="choose-position">
                            <select data-placeholder="Select Feature" multiple name="feature[]" id="edit_feature" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($features as $feature)
                                    <option value="{{$feature->id}}">{{$feature->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-1">
                    <div class="col-12">
                        <label for="edit_work" class="form-label">Work Instructions</label>
                        <div class="choose-position">
                            <select data-placeholder="Select Work Instruction" name="work" id="edit_work" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($work_instructions as $instruction)
                                    <option value="{{$instruction->id}}">{{$instruction->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 ps-sm-0">
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </div>

            </form>
            </div>
        </div>
        </div>
    </div>
    <!--/ Edit ControlPlan Modal -->
@endpush

@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{asset('vendors/js/forms/select/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function(){
        if($('.position-select').length > 0){
            $(".position-select").each((_i, e) => {
                var $e = $(e);
                $e.select2({
                tags: true,
                dropdownParent: $e.parent()
                });
            });
        }

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('control-plans.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'feature', name: 'feature'},
                {data: 'work', name: 'work'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]

        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var url = "{{route('control-plans.index')}}/"+id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(e){
                    if($.trim(e)){
                        $('#editControlPlanModal').modal('show');
                        $('#edit_id').val(e.id);
                        $('#edit_name').val(e.name);
                        $('#edit_feature').val(e.features).trigger('change');
                        $('#edit_work').val(e.work_instruction_id).trigger('change');
                    }
                }
            });
        });
    });
</script>
@endsection
