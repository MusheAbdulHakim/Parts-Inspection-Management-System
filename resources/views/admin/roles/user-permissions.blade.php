@extends('layouts.contentLayoutMaster')

@section('title', 'Assign Permissions')

<x-assets.datatables />

@push('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endpush


@section('content')

    <!-- Permission Table -->
    <div class="card">
        <div class="p-2">
            <div class="card-datatable table-responsive">
                <table id="datatable" class="datatables-permissions table">
                    <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  <!--/ Permission Table -->
@endsection

@push('modals')
    <!-- Edit Permission Modal -->
    <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 pt-0">
            <div class="text-center mb-2">
                <h1 class="mb-1">Edit Permissions</h1>
                <p>Edit permission as per your requirements.</p>
            </div>
            <form method="post" action="{{route('user-permissions.update')}}" class="row">
                @csrf
                @method("PUT")
                <div class="col-12 mb-1">
                    <label class="form-label" for="edit_user">User</label>
                    <select data-placeholder="select user" name="user" id="edit_user" class="form-control">
                        <option value=""></option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="edit_permissions">Permissions</label>
                    <select data-placeholder="select permissions" multiple name="permissions[]" id="edit_permissions" class="form-control select2">
                        <option value=""></option>
                        @foreach ($permissions as $permission)
                            <option>{{$permission->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 ps-sm-0">
                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                </div>
                
            </form>
            </div>
        </div>
        </div>
    </div>
    <!--/ Edit Permission Modal -->
@endpush

@push('vendor-script')
<script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>   
@endpush

@section('page-script')
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('user-permissions.index')}}",
            columns: [
                {data: 'user', name: 'user'},
                {data: 'permissions', name: 'permissions'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
        $('#datatable').on('click','.edit',function(){
            var id = $(this).data('id');
            var user = $(this).data('user');
            var permissions = $(this).data('permissions');
            $('#editPermissionModal').modal('show');
            $('#edit_user').val(user).trigger('change');
            $('#edit_permissions').val(permissions).trigger('change');
        });
        $('.select2').select2();
    });
</script>
@endsection
