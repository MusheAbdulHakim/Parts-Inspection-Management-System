@extends('layouts.contentLayoutMaster')

@section('title', 'Create Calibration')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('summernote/summernote.min.css')}}">
@endsection

@section('content')
  <section id="basic-vertical-layouts">
    <div class="row">
      <div class="col-md-8 col-12">
        <div class="card">
          <div class="card-body">
            <form class="form form-vertical" action="{{route('calibrations.store')}}" method="post" enctype="multipart/form-data">
                @csrf
              <div class="row">
                  <div class="mb-1">
                    <label for="calib_id" class="form-label">ID</label>
                    <input type="text" class="form-control @error('calib_id') is-invalid @enderror" id="calib_id"
                      name="calib_id" placeholder="ID" aria-describedby="calib_id"
                      value="{{ old('calib_id') }}" />
                    @error('calib_id')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-1">
                    <div class="col-12">
                        <label for="tool" class="form-label">Inspection Tool</label>
                        <div class="choose-position">
                            <select data-placeholder="Select Inspection Tool" name="tool" id="tool" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($tools as $tool)
                                    <option value="{{$tool->id}}">{{$tool->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="mb-1">
                    <label for="date_" class="form-label">Calibration Date</label>
                    <input type="text" class="form-control flatpickr @error('date_') is-invalid @enderror" id="date_"
                      name="date_" placeholder="Calibration Date" aria-describedby="calibration-date" tabindex="1"
                      value="{{ old('date_') }}" />
                    @error('date_')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="mb-1">
                    <label for="interval" class="form-label">Calibration Interval</label>
                    <input type="text" class="form-control flatpickr_range_month @error('interval') is-invalid @enderror" id="interval"
                      name="interval" placeholder="Calibration Interval Date" aria-describedby="calibration-date" tabindex="1"
                      value="{{ old('interval') }}" />
                    @error('interval')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="mb-1">
                    <label for="lfm" class="form-label">Calibration certificate</label>
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="text" name="calibrationfile">
                        <span class="input-group-btn">
                          <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i data-feather="upload-cloud"></i> Choose
                          </a>
                        </span>
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
  <script src="{{asset('summernote/summernote.min.js')}}"></script>
  <script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
  <script>
    $(document).ready(function(){
      $('.summernote').summernote();

      if($('.position-select').length > 0){
        $(".position-select").each((_i, e) => {
            var $e = $(e);
            $e.select2({
            tags: true,
            dropdownParent: $e.parent()
            });
        });
      }
        if ($('.flatpickr_range_month').length) {
            $('.flatpickr_range_month').flatpickr({
                mode: 'range',
                altFormat: 'M',
                altInput: true,
            });
        }
        $('#lfm').filemanager('file');
    });
  </script>
@endsection

