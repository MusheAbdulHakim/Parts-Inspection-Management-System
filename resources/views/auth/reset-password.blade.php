@extends('layouts/fullLayoutMaster')

@section('title', 'Reset Password')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  <div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
      <!-- Reset Password basic -->
      <div class="card mb-0">
        <div class="card-body">
          {{-- brand  --}}
          <x-brand />
          {{-- / brand  --}}
          
          <h4 class="card-title mb-1">Reset Password 🔒</h4>
          <p class="card-text mb-2">Your new password must be different from previously used passwords</p>

          <form class="auth-reset-password-form mt-2" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-1">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                placeholder="john@example.com" aria-describedby="email" tabindex="1" value="{{ old('email') }}" required
                autofocus />
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="mb-1">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="reset-password-new">New Password</label>
              </div>
              <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                <input type="password" class="form-control form-control-merge @error('password') is-invalid @enderror"
                  id="reset-password-new" name="password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="reset-password-new" tabindex="2" autofocus required />
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="mb-1">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="reset-password-confirm">Confirm Password</label>
              </div>
              <div class="input-group input-group-merge form-password-toggle">
                <input type="password" class="form-control form-control-merge" id="reset-password-confirm"
                  name="password_confirmation" autocomplete="new-password"
                  placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                  aria-describedby="reset-password-confirm" tabindex="3" />
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" tabindex="4">Set New Password</button>
          </form>

          <p class="text-center mt-2">
            @if (Route::has('login'))
              <a href="{{ route('login') }}">
                <i data-feather="chevron-left"></i> Back to login
              </a>
            @endif
          </p>
        </div>
      </div>
      <!-- /Reset Password basic -->
    </div>
  </div>
@endsection
