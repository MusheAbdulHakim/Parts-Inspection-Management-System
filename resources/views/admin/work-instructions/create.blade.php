@extends('layouts.contentLayoutMaster')

@section('title', 'Create Work Instruction')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/file-uploaders/dropzone.min.css')}}">
@endsection

@section('content')
  <section id="basic-vertical-layouts">
    <div class="row">
      <div class="col-md-8 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Create Work Instruction</h4>
          </div>
          <div class="card-body">
            <form class="form form-vertical" action="{{route('work-instructions.store')}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="row">
                  <div class="mb-1">
                    <label for="register-username" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                      name="name" placeholder="Name" aria-describedby="name" tabindex="1" autofocus
                      value="{{ old('name') }}" />
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-1">
                    <label for="revision" class="form-label">Revision</label>
                    <input type="text" class="form-control @error('revision') is-invalid @enderror" id="username"
                      name="revision" placeholder="Revision" aria-describedby="revision"
                      value="{{ old('revision') }}" tabindex="2"/>
                    @error('revision')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                <div class="mb-1">
                    <label for="lfm" class="form-label">Files</label>
                    <div class="input-group">
                        <input id="thumbnail" class="form-control @error('filepath') is-invalid @enderror" type="text" name="filepath">
                        <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i data-feather="upload-cloud"></i> Choose
                        </a>
                        </span>
                        @error('filepath')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;">
                </div>

                <div class="col-12">
                  <button type="submit" id="submit-all" class="btn btn-primary me-1">Submit</button>
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
  <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
  <script>
     $('#lfm').filemanager('file');
  </script>
@endsection

