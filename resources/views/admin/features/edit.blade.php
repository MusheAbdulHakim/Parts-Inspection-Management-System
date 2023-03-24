@extends('layouts.contentLayoutMaster')

@section('title', 'Edit Feature')

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
            <form class="form form-vertical" action="{{route('features.update', $feature)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PUT")
              <div class="row">
                  <div class="mb-1">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                      name="name" placeholder="Name" aria-describedby="part number" tabindex="1" autofocus
                      value="{{ $feature->name ?? old('name') }}" />
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  
                  <div class="mb-1">
                    <div class="col-12">
                        <label for="feature_type" class="form-label">Feature Type</label>
                          <select data-placeholder="Select Type" name="feature_type" id="feature_type" class="form-control select2">
                              <option value=""></option>
                              <option value="binary">Binary Feature</option>
                              <option value="number">Number Feature</option>
                              <option value="gauge">Gauge Feature</option>
                          </select>
                    </div>
                  </div>
                  
                  <div class="number_feature {{($feature->type != 'number') ? 'd-none': ''}}">
                    <div class="col-12">
                      <label class="form-label" for="target">Target</label>
                      <input
                          type="text"
                          id="target"
                          name="target"
                          value="{{ $feature->target ?? old('target')}}"
                          class="form-control"
                          placeholder="Target"
                        />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="upper">Upper Limit</label>
                        <input
                            type="text"
                            id="upper"
                            name="upper_limit"
                            value="{{ $feature->upper_limit ?? old('upper_limit')}}"
                            class="form-control"
                            placeholder="Upper Limit"
                        />
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="lower">Lower Limit</label>
                        <input
                            type="text"
                            id="lower"
                            name="lower_limit"
                            value="{{ $feature->lower_limit ?? old('lower_limit')}}"
                            class="form-control"
                            placeholder="Lower Limit"
                        />
                    </div>
                  </div>
                  <div class="mb-1 bool_field {{($feature->type == 'number') ? 'd-none': ''}}">
                    <div class="col-12">
                      <label for="bool" class="form-label">Pass / Fail</label>
                      <select name="bool" data-placeholder="Select Option" id="bool" class="form-control select2">
                        <option value=""></option>
                          <option value="1">True</option>
                          <option value="0">False</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-1">
                    <div class="col-12">
                      <label class="form-label" for="control_method">Control Method</label>
                      <textarea name="control_method" class="form-control summernote"
                      placeholder="Control Method" id="control_method" cols="3" rows="3">{{$feature->control_method ?? old('control_method')}}</textarea>
                    </div>
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
      $('#feature_type').val('{{$feature->type ?? old("type")}}').trigger('change');
      $('#bool').val('{{$feature->bool ?? old("bool")}}').trigger('change');
      $('#feature_type').change(function(){
        if($(this).val() === 'number'){
          $('.number_feature').removeClass('d-none');
          $('.bool_field').addClass('d-none');
        }else{
          $('.number_feature').addClass('d-none');
          $('.bool_field').removeClass('d-none');
        }
      })
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
      $('#lfm').filemanager('file');
    });
  </script>
@endsection

