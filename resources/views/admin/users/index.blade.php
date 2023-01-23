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
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Active</th>
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
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'active', name: 'active'},
            {data: 'avatar', name: 'avatar', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('table').on('click','.update_status', function(){
      var status = $(this).data('status');
      var user = $(this).data('user');
      $.ajax({
        url: "{{route('user.status.update')}}",
        type: "POST",
        data: {
          user: user,
          status: status
        },
        success: function(e){
          if(e.type == '1'){
            toastr.success(e.message)
          }
          if(e.type == '0'){
            toastr.error(e.message)
          }
        },
        complete: function(){
          $('#datatable').DataTable().ajax.reload();
        }
      })
    })
      
  })
</script>
@endsection


