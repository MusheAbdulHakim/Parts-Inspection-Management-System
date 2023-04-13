@extends('layouts.contentLayoutMaster')

@section('title', 'Calibrations')

<x-assets.datatables />


@push('breadcrumb-right')
@can('create-calibration')
<x-buttons.primary :link="route('calibrations.create')" text="New Calibration" />
@endcan
@endpush

@section('content')
<!-- table -->
<section>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="p-2">
            <table id="datatable" class="table table-bordered dt-responsive">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tool</th>
                    <th>Certificate</th>
                    <th>Date</th>
                    <th>Interval</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
          </div>
        </div>
      </div>
    </div>
</section>
<!--/ table -->

@endsection

@section('page-script')
<script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
  $(document).ready(function(){
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('calibrations.index')}}",
        columns: [
            {data: 'calib_id', name: 'calib_id'},
            {data: 'tool', name: 'tool'},
            {data: 'cert', name: 'cert', orderable: false, searchable: false},
            {data: 'date_', name: 'date_'},
            {data: 'interval', name: 'interval'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
  })
  var lfm = function(attr, type, options) {
    let button = document.getElementsByClassName(attr);

    $('#datatable').on('click','.filemanager',function(){
      var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
      var target_input = $(this).data('input');
      var target_preview = $(this).data('preview');

      window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
      window.SetUrl = function (items) {
        var file_path = items.map(function (item) {
          return item.url;
        }).join(',');

        // set the value of the desired input to image url
        target_input.value = file_path;
        target_input.trigger('change');
        // trigger change event
        target_preview.trigger('change');
      };

    });

  };

  lfm('filemanager', 'file','file');
</script>
@endsection


