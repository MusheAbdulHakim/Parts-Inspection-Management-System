@extends('layouts.contentLayoutMaster')

@section('title', 'New Inspection')

@section('vendor-style')
  <link rel="stylesheet" href="{{asset('vendors/css/forms/select/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendors/css/forms/wizard/bs-stepper.min.css')}}">
@endsection

@section('page-style')
  <link rel="stylesheet" href="{{asset('summernote/summernote.min.css')}}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
<section class="horizontal-wizard">
    <div class="bs-stepper inspection-wizard">
      <div class="bs-stepper-header" role="tablist">
        <div class="step" data-target="#partnumber" role="tab" id="partnumber-trigger">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-box">1</span>
            </button>
          </div>
          <div class="line">
            <i data-feather="chevron-right" class="font-medium-2"></i>
          </div>
        <div class="step" data-target="#controlplan-revision" role="tab" id="controlplan-revision-trigger">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-box">2</span>
          </button>
        </div>
        <div class="line">
          <i data-feather="chevron-right" class="font-medium-2"></i>
        </div>
        <div class="step" data-target="#controlplan-revision1" role="tab" id="controlplan-revision1-trigger">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-box">3</span>
          </button>
        </div>
        <div class="line">
            <i data-feather="chevron-right" class="font-medium-2"></i>
          </div>
        <div class="step" data-target="#controlplan-revision2" role="tab" id="controlplan-revision2-trigger">
          <button type="button" class="step-trigger">
            <span class="bs-stepper-box">4</span>
          </button>
        </div>

      </div>
      <div class="bs-stepper-content">
        <div id="partnumber" class="content" role="tabpanel" aria-labelledby="partnumber-trigger">
            <form>
                <div class="row">
                    <div class="mb-1">
                        <label for="user_name">UserName</label>
                        <input type="text" disabled value="{{auth()->user()->name}}" class="form-control">
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="part_number">Please Scan Part Number</label>
                        <input type="text" name="partnumber" id="part_number" class="form-control" placeholder="Enter Part Number" />
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev" disabled>
                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary btn-next" id="query_partnumber">
                <span class="align-middle d-sm-inline-block d-none">Next</span>
                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
              </button>
            </div>
        </div>
        <div id="controlplan-revision" class="content" role="tabpanel" aria-labelledby="controlplan-revision-trigger">
          <form>
            <div class="row">
              <div class="col-md-8">
                <embed src="" width="100%" height="375" />
              </div>
              <div class="col-md-4">
                <div class="row">
                    <div class="mb-1">
                        <label for="batch_no">Batch Number</label>
                        <input type="text" placeholder="Enter Batch Number" class="form-control">
                    </div>
                    <div class="mb-1">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" />
                    </div>
                </div>
              </div>
            </div>
          </form>
          <div class="d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev">
              <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-next">
              <span class="align-middle d-sm-inline-block d-none">Next</span>
              <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
            </button>
          </div>
        </div>
        <div id="controlplan-revision1" class="content" role="tabpanel" aria-labelledby="controlplan-revision1-trigger">
          <form>
            <div class="row">
                <div class="col-md-6">
                    <embed src="" width="100%" height="375" />
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="mb-1">
                        <div class="col-12">
                          <label class="form-label" for="control_method">Control Method</label>
                          <textarea name="control_method" class="form-control summernote"
                          placeholder="Control Method" id="control_method" cols="3" rows="3">{{old('control_method')}}</textarea>
                        </div>
                      </div>
                      <div class="mb-1">
                          <label class="form-label" for="quantity">Quantity</label>
                          <input type="text" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" />
                      </div>
                  </div>
                </div>
            </div>
          </form>
          <div class="d-flex justify-content-between">
            <button class="btn btn-primary btn-prev">
              <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
              <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-next">
              <span class="align-middle d-sm-inline-block d-none">Next</span>
              <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
            </button>
          </div>
        </div>
        <div id="controlplan-revision2" class="content" role="tabpanel" aria-labelledby="controlplan-revision2-trigger">
            <form>
              <div class="row">
                  <div class="col-md-6">
                    <embed src="" width="100%" height="375" />
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="mb-1">
                          <div class="col-12">
                            <label class="form-label" for="control_method2">Control Method</label>
                            <textarea name="control_method2" class="form-control summernote"
                            placeholder="Control Method" i2d="control_method2" cols="3" rows="3">{{old('control_method')}}</textarea>
                          </div>
                        </div>
                        <div class="mb-1">
                            <div class="row custom-options-checkable g-1">
                                <div class="col-md-6">
                                  <input
                                    class="custom-option-item-check"
                                    type="radio"
                                    name="customOptionsCheckableRadios"
                                    id="customOptionsCheckableRadios1"
                                    value
                                    checked
                                  />
                                  <label class="custom-option-item p-1" for="customOptionsCheckableRadios1">
                                    <span class="d-flex justify-content-between flex-wrap mb-50">
                                      <span class="fw-bolder">Pass</span>
                                    </span>
                                  </label>
                                </div>

                                <div class="col-md-6">
                                  <input
                                    class="custom-option-item-check"
                                    type="radio"
                                    name="customOptionsCheckableRadios"
                                    id="customOptionsCheckableRadios2"
                                    value
                                  />
                                  <label class="custom-option-item p-1" for="customOptionsCheckableRadios2">
                                    <span class="d-flex justify-content-between flex-wrap mb-50">
                                      <span class="fw-bolder">Fail</span>
                                    </span>
                                  </label>
                                </div>
                              </div>
                        </div>
                    </div>
                  </div>
              </div>
            </form>
            <div class="d-flex justify-content-between">
                <button class="btn btn-primary btn-prev">
                    <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                </button>
                <button class="btn btn-success btn-submit">Submit</button>
            </div>
          </div>
      </div>
    </div>
  </section>
  <!-- /Horizontal Wizard -->
@endsection


@section('vendor-script')
  <script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>
  <script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/wizard/bs-stepper.min.js')}}"></script>
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

@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
<script src="{{asset('summernote/summernote.min.js')}}"></script>
<script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script>
    var horizontalWizard = document.querySelector('.inspection-wizard');
    if (typeof horizontalWizard !== undefined && horizontalWizard !== null) {
        var numberedStepper = new Stepper(horizontalWizard),
        $form = $(horizontalWizard).find('form');
            $form.each(function () {
            var $this = $(this);
                $this.validate({
                    rules: {
                        partnumber: {
                            required: true
                        }
                    }
                });
            });

        $(horizontalWizard)
        .find('.btn-next')
        .each(function () {
            $(this).on('click', function (e) {
            var isValid = $(this).parent().siblings('form').valid();
            if (isValid) {
                numberedStepper.next();
            } else {
                e.preventDefault();
            }
            });
        });

        $(horizontalWizard)
        .find('.btn-prev')
        .on('click', function () {
            numberedStepper.previous();
        });

        $(horizontalWizard)
        .find('.btn-submit')
        .on('click', function () {
            var isValid = $(this).parent().siblings('form').valid();
            if (isValid) {
            alert('inspection-wizard Submitted..!!');
            }
        });
    }
</script>
<script>
    $(document).ready(function(){
        $('#query_partnumber').click(function(){
            if($(this).parent().siblings('form').valid()){
                var partnumber = $('#part_number').val();
                $.ajax({
                    url: "{{route('product.partnumber')}}",
                    type: "POST",
                    data: {
                        part_no: partnumber
                    },
                    success: function(e){
                        console.log((e.docs))
                        $('#controlplan-revision embed').attr('src', (e.docs))
                    }
                })
            }
        })
    })
</script>
@endsection
