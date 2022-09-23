@extends('layouts.fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
  <div class="auth-wrapper auth-basic px-2">
    <div class="auth-inner my-2">
      <!-- Login basic -->
      <div class="card mb-0">
        <div class="card-body">
          {{-- brand  --}}
            <x-brand />
          {{-- / brand  --}}

          <h4 class="card-title mb-1">Verify Your Email Address! </h4>
          @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" role="alert">
              <div class="alert-body">
                A new verification link has been sent to the email address you provided during registration.
              </div>
            </div>
          @endif
          <p class="card-text mb-2">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we
            just emailed to you? If you didn\'t receive the email, we will gladly send you another.
          </p>

          <div class="mt-4 d-flex justify-content-between">
            <form method="POST" action="{{ route('verification.send') }}">
              @csrf
              <button type="submit"
                class="btn btn-link btn-flat-secondary">{{ __('click here to request another') }}</button>
            </form>

            <form method="POST" action="/logout">
              @csrf

              <button type="submit" class="btn btn-danger">
                Log Out
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
