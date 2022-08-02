@extends('layouts.contentLayoutMaster')

@section('title', 'Users')

<x-assets.datatables />


@push('breadcrumb-right')
@can('create-user')
<x-buttons.primary :link="route('users.create')" text="Create User" />
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
                    <th>Email</th>
                    <th>Role</th>
                    <th>Avatar</th>
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
<script>
    $(document).ready(function(){

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('users.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'avatar', name: 'avatar', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    })
</script>
@endsection


