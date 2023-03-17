@extends('layouts.contentLayoutMaster')

@section('title', 'General Settings')

@section('content')
<section id="basic-vertical-layouts">
    <div class="row">
      <div class="col-md-8 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">General App Settings</h4>
          </div>
          <div class="card-body">
            <form class="form form-vertical" action="{{route('settings.general')}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="row">
                
                <div class="mb-1">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                      name="logo" placeholder="johndoe" aria-describedby="logo" tabindex="1" autofocus
                      value="{{ $settings->logo ?? old('logo') }}" />
                    @error('logo')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  

                <div class="mb-1">
                    <label for="favicon" class="form-label">Favicon</label>
                    <input class="form-control @error('favicon') is-invalid @enderror" placeholder="$" type="file" id="favicon" name="favicon">
                    @error('favicon')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>    
                <div class="mb-1">
                    <label for="currency" class="form-label">Currency</label>
                    <input type="text" class="form-control @error('currency') is-invalid @enderror" id="currency" value="{{$settings->currency ?? old('currency')}}" name="currency">
                    @error('currency')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
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

