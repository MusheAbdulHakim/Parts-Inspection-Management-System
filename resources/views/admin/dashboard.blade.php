@extends('layouts.contentLayoutMaster')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-xl-4 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <a href="{{route('users.index')}}"><div class="avatar bg-light-info p-50 mb-1">
                    <div class="avatar-content">
                        <i data-feather="users"></i>
                    </div>
            </div>
            </a>
              <h2 class="fw-bolder">{{$users_count}}</h2>
              <p class="card-text">Users</p>
          </div>
      </div>
  </div>
  
</div>
@endsection
