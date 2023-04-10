@extends('layouts.contentLayoutMaster')

@section('title', 'Features')

<x-assets.datatables />


@push('breadcrumb-right')
@can('create-feature')
<x-buttons.primary :link="route('features.create')" text="New FEature" />
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
                    <th>Name</th>
                    <th>Type</th>
                    <th>Target</th>
                    <th>Lower Limit</th>
                    <th>Upper Limit</th>
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
        ajax: "{{route('features.index')}}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'type', name: 'type'},
            {data: 'target', name: 'target'},
            {data: 'lower_limit', name: 'lower_limit'},
            {data: 'upper_limit', name: 'upper_limit'},
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


