@extends('layouts.contentLayoutMaster')

@section('title', 'Create User')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
@endsection


@section('content')
<section id="basic-vertical-layouts">
    <div class="row">
      <div class="col-md-8 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Edit User</h4>
          </div>
          <div class="card-body">
            <form class="form form-vertical" action="{{route('users.update',$user)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PUT")
              <div class="row">
                
                <div class="mb-1">
                    <label for="register-username" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="register-username"
                      name="name" placeholder="john doe" aria-describedby="register-username" tabindex="1" autofocus
                      value="{{ $user->name ?? old('name') }}" />
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-1">
                    <label for="username" class="form-label">UserName</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                      name="username" placeholder="johndoe" aria-describedby="username" tabindex="1" autofocus
                      value="{{ $user->username ?? old('username') }}" />
                    @error('username')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-1">
                    <label for="register-email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="register-email"
                      name="email" placeholder="john@example.com" aria-describedby="register-email" tabindex="2"
                      value="{{ $user->email ?? old('email') }}" />
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="mb-1">
                    <label for="role" class="form-label">Role</label>
                    <select data-placeholder="Select User Role" class="select2 form-control" name="role">
                      <option value=""></option>
                        @foreach ($roles as $role)
                          <option {{in_array($role->name,$user->getRoleNames()->toArray()) ? 'selected': ''}} value="{{$role->name}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                  </div>
      
                  <div class="mb-1">
                    <label for="register-password" class="form-label">Password</label>
      
                    <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                      <input type="password" class="form-control form-control-merge @error('password') is-invalid @enderror"
                        id="register-password" name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="register-password" tabindex="3" />
                      <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
      
                  <div class="mb-1">
                    <label for="register-password-confirm" class="form-label">Confirm Password</label>
      
                    <div class="input-group input-group-merge form-password-toggle">
                      <input type="password" class="form-control form-control-merge" id="register-password-confirm"
                        name="password_confirmation"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="register-password" tabindex="3" />
                      <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                    </div>
                  </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary me-1">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      
    </div>
  </section>
@endsection

@section('vendor-script')
  <script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>
@endsection

@section('page-script')
<script>
  $(document).ready(function(){
    $('.select2').select2();
  });
</script>
@endsection