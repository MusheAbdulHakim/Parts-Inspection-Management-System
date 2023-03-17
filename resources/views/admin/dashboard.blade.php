@extends('layouts.contentLayoutMaster')

@section('title', 'Dashboard')

@section('content')
<div class="row">
  <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <div class="avatar bg-light-info p-50 mb-1">
                  <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye font-medium-5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                  </div>
              </div>
              <h2 class="fw-bolder">36.9k</h2>
              <p class="card-text">Views</p>
          </div>
      </div>
  </div>
  
</div>
@endsection
