@extends('layouts.contentLayoutMaster')

@section('title', 'Home')

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
  <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <div class="avatar bg-light-warning p-50 mb-1">
                  <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square font-medium-5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                  </div>
              </div>
              <h2 class="fw-bolder">12k</h2>
              <p class="card-text">Comments</p>
          </div>
      </div>
  </div>
  <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <div class="avatar bg-light-danger p-50 mb-1">
                  <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag font-medium-5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                  </div>
              </div>
              <h2 class="fw-bolder">97.8k</h2>
              <p class="card-text">Orders</p>
          </div>
      </div>
  </div>
  <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <div class="avatar bg-light-primary p-50 mb-1">
                  <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart font-medium-5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                  </div>
              </div>
              <h2 class="fw-bolder">26.8</h2>
              <p class="card-text">Bookmarks</p>
          </div>
      </div>
  </div>
  <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <div class="avatar bg-light-success p-50 mb-1">
                  <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award font-medium-5"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                  </div>
              </div>
              <h2 class="fw-bolder">689</h2>
              <p class="card-text">Reviews</p>
          </div>
      </div>
  </div>
  <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="card text-center">
          <div class="card-body">
              <div class="avatar bg-light-danger p-50 mb-1">
                  <div class="avatar-content">
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck font-medium-5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                  </div>
              </div>
              <h2 class="fw-bolder">2.1k</h2>
              <p class="card-text">Returns</p>
          </div>
      </div>
  </div>
</div>
@endsection
