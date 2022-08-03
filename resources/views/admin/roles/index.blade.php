@extends('layouts.contentLayoutMaster')

@section('title', 'Roles')

<x-assets.datatables />

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@push('breadcrumb-right')
@can('create-role')
<x-buttons.primary text="create role" target="#addPermissionModal"  />
@endcan
@endpush

@section('content')
<h3>Roles List</h3>
<p class="mb-2">
  A role provided access to predefined menus and features so that depending <br />
  on assigned role an administrator can have access to what he need
</p>

<!-- Role cards -->
<div class="row">

  @foreach ($roles as $role)
      
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <span>Total {{$role->users->count()}} users</span>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li
              data-bs-toggle="tooltip"
              data-popup="tooltip-custom"
              data-bs-placement="top"
              title="Vinnie Mostowy"
              class="avatar avatar-sm pull-up"
            >
            @foreach ($role->users as $roleUser)
              <img class="rounded-circle" src="{{!empty($roleUser->profile_photo_path) ? asset('storage/'.$roleUser->profile_photo_path): asset('images/avatars/1.png')}}" alt="Avatar" />
            @endforeach
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
          <div class="role-heading">
            <h4 class="fw-bolder">{{$role->name}}</h4>
            <a href="javascript:;" data-id="{{$role->id}}" data-name="{{$role->name}}" data-permissions="{{$role->getAllPermissions()->pluck('name')}}" class="edit_role">
              <small class="fw-bolder">Edit Role</small>
            </a>
          </div>
          <a href="javascript:void(0);" class="text-body"><i data-feather="copy" class="font-medium-5"></i></a>
        </div>
      </div>
    </div>
  </div>
  
  @endforeach
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="row">
        <div class="col-sm-5">
          <div class="d-flex align-items-end justify-content-center h-100">
            <img
              src="{{asset('images/illustration/faq-illustrations.svg')}}"
              class="img-fluid mt-2"
              alt="Image"
              width="85"
            />
          </div>
        </div>
        <div class="col-sm-7">
          <div class="card-body text-sm-end text-center ps-sm-0">
            <a
              href="javascript:void(0)"
              data-bs-target="#addRoleModal"
              data-bs-toggle="modal"
              class="stretched-link text-nowrap add-new-role"
            >
              <span class="btn btn-primary mb-1">Add New Role</span>
            </a>
            <p class="mb-0">Add role, if it does not exist</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--/ Role cards -->

<h3 class="mt-50">Total users with their roles</h3>
<p class="mb-2">Find all of your company’s administrator accounts and their associate roles.</p>
<!-- table -->
<div class="card">
  <div class="p-2 table-responsive">
    <table id="datatable" class="user-list-table table">
      <thead class="table-light table table-bordered dt-responsive">
        <tr>
          
          <th>Role</th>
          <th>Permission</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<!-- table -->
@endsection

@push('modals')
<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
        <div class="modal-content">
        <div class="modal-header bg-transparent">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body px-5 pb-5">
            <div class="text-center mb-4">
              <h1 class="role-title">Add New Role</h1>
              <p>Set role permissions</p>
            </div>
            <!-- Add role form -->
            <form id="addRoleForm" class="row" action="{{route('roles.store')}}" method="post">
              @csrf
                <div class="col-12">
                    <label class="form-label" for="modalRoleName">Role Name</label>
                    <input
                    type="text"
                    id="modalRoleName"
                    name="role"
                    class="form-control"
                    placeholder="Enter role name"
                    tabindex="-1"
                    data-msg="Please enter role name"
                    />
                </div>
                <div class="col-12">
                    <h4 class="mt-2 pt-50">Role Permissions</h4>
                    <!-- Permission table -->
                    <div class="table-responsive">
                        <table class="table table-flush-spacing">
                            <tbody>
                                <tr>
                                    <td class="text-nowrap">
                                        Grant All Access
                                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                            <i data-feather="info"></i>
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                      <div class="form-check">
                                          <label class="form-check-label" for="selectAll"> Select All </label>
                                          <input class="form-check-input" type="checkbox" id="selectAll" />
                                      </div>
                                    </td>
                                </tr>                             
                                
                                <tr>
                                  <td>
                                      <div class="row">
                                          @foreach ($permissions as $permission)
                                          <div class="col-4">
                                            <div class="d-flex">
                                              <div class="form-check me-3 me-lg-5">
                                                <input class="form-check-input" type="checkbox" id="{{$permission->name}}Read" name="permission[]" value="{{$permission->name}}" />
                                                <label class="form-check-label text-nowrap" for="{{$permission->name}}Read"> {{$permission->name}} </label>
                                              </div> 
                                            </div>
                                          </div>
                                          @endforeach  
                                      </div>
                                        </td>
                                    </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- Permission table -->
                    
                </div>
                <div class="col-12 text-center mt-2">
                    <button type="submit" class="btn btn-primary me-1">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                    Discard
                    </button>
                </div>
            </form>
            <!--/ Add role form -->
        </div>
        </div>
    </div>
</div>
<!--/ Add Role Modal -->

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
      <div class="modal-header bg-transparent">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-5 pb-5">
          <div class="text-center mb-4">
            <h1 class="role-title">Edit Role</h1>
            <p>Edit role permissions</p>
          </div>
          <!-- Edit role form -->
          <form id="editRoleForm" class="row" action="{{route('roles.update')}}" method="post">
            @csrf
            @method("PUT")
              <div class="col-12">
                  <label class="form-label" for="editModalRoleName">Role Name</label>
                  <input
                  type="text"
                  id="editModalRoleName"
                  name="role"
                  class="form-control"
                  placeholder="Enter role name"
                  tabindex="-1"
                  data-msg="Please enter role name"
                  />
              </div>
              <input type="hidden" name="id" id="edit_id">
              <div class="col-12">
                  <h4 class="mt-2 pt-50">Role Permissions</h4>
                  <!-- Permission table -->
                  <div class="table-responsive">
                      <table class="table table-flush-spacing">
                          <tbody>
                              <tr>
                                  <td class="text-nowrap">
                                      Grant All Access
                                      <span data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system">
                                          <i data-feather="info"></i>
                                      </span>
                                  </td>
                                  <td class="text-nowrap">
                                    <div class="form-check">
                                        <label class="form-check-label" for="selectAll"> Select All </label>
                                        <input class="form-check-input" type="checkbox" id="selectAll" />
                                    </div>
                                  </td>
                              </tr>                             
                              
                              <tr class="permRow">
                                <td>
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                        <div class="col-4">
                                          <div class="d-flex">
                                            <div class="form-check me-3 me-lg-5">
                                              <input class="form-check-input" type="checkbox" id="{{$permission->name}}_id" name="permission[]" value="{{$permission->name}}" />
                                              <label class="form-check-label text-nowrap" for="{{$permission->name}}_id"> {{$permission->name}} </label>
                                            </div> 
                                          </div>
                                        </div>
                                        @endforeach  
                                    </div>
                                      </td>
                                  </tr>
                              
                          </tbody>
                      </table>
                  </div>
                  <!-- Permission table -->
                  
              </div>
              <div class="col-12 text-center mt-2">
                  <button type="submit" class="btn btn-primary me-1">Submit</button>
                  <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                  Discard
                  </button>
              </div>
          </form>
          <!--/ Edit role form -->
      </div>
      </div>
  </div>
</div>
<!--/ Edit Role Modal -->
@endpush



@section('page-script')
<script>
    $(document).ready(function(){
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('roles.index')}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'permissions', name: 'permissions'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
            
        });
      
        $('body').on('click','.edit_role',function(){
          var id = $(this).data('id');
          var role = $(this).data('name');
          var permissions = $(this).data('permissions');
          console.log(role)
          console.log(permissions)
          $('#editRoleModal').modal('show');
          $('#edit_id').val(id);
          $('#editModalRoleName').val(role);
         var boxes = document.querySelectorAll('.permRow [type="checkbox"]')
          boxes.forEach(e => {
            if(permissions.includes(e.value) && e.checked == false){
              e.checked = true
            }
          });
          
        });
        

        $('#selectAll').click(function(t){
          var boxes = document.querySelectorAll('[type="checkbox"]')
          boxes.forEach(e => {
            e.checked = t.target.checked;
          });
        }).trigger('change');
    });
</script>

@endsection
