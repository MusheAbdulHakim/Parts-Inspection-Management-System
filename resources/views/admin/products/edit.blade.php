@extends('layouts.contentLayoutMaster')

@section('title', 'Edit Product')

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
            <form class="form form-vertical" action="{{route('products.update', $product)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PUT")
              <div class="row">
                  <div class="mb-1">
                    <label for="part_no" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="part_no"
                      name="part_no" placeholder="Part Number" aria-describedby="part number" tabindex="1" autofocus
                      value="{{ $product->part_no ?? old('part_no') }}" />
                    @error('part_no')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  
                    <div class="mb-1">
                      <div class="col-12">
                          <label for="plan" class="form-label">Control Plan</label>
                          <div class="choose-position">
                              <select data-placeholder="Select Control Plan" name="plan" id="plan" class="form-control position-select">
                                  <option value=""></option>
                                  @foreach ($control_plans as $plan)
                                      <option {{($plan->id == $product->control_plan_id) ? 'selected': ''}} value="{{$plan->id}}">{{$plan->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="mb-1">
                    <div class="col-12">
                        <label for="project" class="form-label">Project</label>
                        <div class="choose-position">
                            <select data-placeholder="Select Project" name="project" id="project" class="form-control position-select">
                                <option value=""></option>
                                @foreach ($projects as $project)
                                    <option {{($project->id == $product->project_id) ? 'selected': ''}} value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                  <div class="mb-1">
                    <label for="lfm" class="form-label">Documents</label>
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="text" name="filepath" value="{{$product->docs}}">
                        <span class="input-group-btn">
                          <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i data-feather="upload-cloud"></i> Choose
                          </a>
                        </span>
                      </div>
                      <img id="holder" src="{{$product->docs}}" style="margin-top:15px;max-height:100px;">
                  </div>
                  <div class="mb-1">
                    <div class="col-12">
                      <label class="form-label" for="description">Description</label>
                      <textarea name="description" class="form-control summernote"
                      placeholder="Description" id="description" cols="3" rows="3">{{$product->description ?? old('description')}}</textarea>
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

