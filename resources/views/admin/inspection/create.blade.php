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
        <div class="d-flex justify-content-right align-items-right ms-5 d-none">Control Plan: <b id="control_plan" class="ms-1"> </b></div>
      </div>
      <div class="bs-stepper-content">
        <div id="partnumber" class="content" role="tabpanel" aria-labelledby="partnumber-trigger">
            <form>
                <div class="row">
                    <div class="mb-1">
                        <label for="user_name">UserName</label>
                        <input type="text" disabled value="{{auth()->user()->name}}" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="mb-1">
                            <label class="form-label" for="part_number">Please Scan Part Number</label>
                            <input type="text" name="partnumber" id="part_number" class="form-control" placeholder="Enter Part Number" />
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev" disabled>
                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
              </button>
              <button class="btn btn-primary" id="query_partnumber">
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
                        <label>Project: <b class="project_name"></b></label>
                    </div>
                    <div class="mb-1">
                        <label>Product: <b class="product_name"></b></label>
                    </div>
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
            <button class="btn btn-primary btn-next" id="query_feature">
              <span class="align-middle d-sm-inline-block d-none">Next</span>
              <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
            </button>
          </div>
        </div>
        <div id="dynamic_features"></div>

    </div>
</section>
@endsection


@section('vendor-script')
  <script src="{{asset(mix('vendors/js/forms/select/select2.full.min.js'))}}"></script>
  <script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
  <script src="{{asset('vendors/js/forms/wizard/bs-stepper.min.js')}}"></script>
  <script>
    $(document).ready(function(){
      $('.summernote').summernote();
      $('#control_method1').summernote('disable');
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
    let queryData;
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

        $('#query_partnumber').on('click', function(e){
            var isValid = $('#partnumber form').valid();
            var product = queryProduct($('#part_number').val());
            if(isValid && (product == true)){
                $('#control_plan').parent().removeClass('d-none');
                $('#control_plan').append(queryData.control_plan)
                projectProductLabels(queryData.project_name, queryData.product.part_no)
                var headCount = 3;
                $.each((queryData.features),function(index, feature){
                    var featureHeader = `
                        <div class="line">
                        <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                        <div class="step" data-target="#controlplan-revision${index}" role="tab" id="controlplan-revision${index}-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">${headCount}</span>
                        </button>
                        </div>`;
                    $('#controlplan-revision-trigger').after(featureHeader);
                    headCount++;
                });
                numberedStepper.next();
            }else{
                e.preventDefault();
            }
        });

        $('#query_feature').on('click', function(e){
            var isValid = $('#controlplan-revision form').valid();
            if(isValid){
                var featuresArr = queryFeatures(queryData.features);
                $.each(featuresArr, function(index, feature) {
                    var featureStep = `<div id="controlplan-revision${index}" class="content" role="tabpanel" aria-labelledby="controlplan-revision${index}-trigger">
                        <form>
                            <div class="row">
                            <div class="col-md-6">
                                <embed src="${queryData.work_instruction.files}" width="100%" height="375" />
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-1">
                                        <label>Project: <b>${queryData.project_name}</b></label>
                                    </div>
                                    <div class="mb-1">
                                        <label>Product: <b>${queryData.product.part_no}</b></label>
                                    </div>
                                    <div class="mb-1">
                                        <label>Feature: <b>${feature.name}</b></label>
                                    </div>
                                    <div class="mb-1">
                                        <div class="col-12">
                                        <label class="form-label">Control Method</label>
                                        <textarea class="form-control summernote"
                                        placeholder="Control Method" id="control_method${index}" cols="3" rows="3">${feature.control_method}</textarea>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <label for="batch_no">Contro Tool</label>
                                        <input type="text" readonly value="${feature.tool}" class="form-control">
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label">Measure Value</label>
                                        <input type="text" name="measure_value[]" class="form-control" placeholder="Enter Measure value" />
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
                            <button class="btn btn-primary btn-next next_feature">
                                <span class="align-middle d-sm-inline-block d-none">Next</span>
                                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                        </div>
                    </div>`;
                    $('#controlplan-revision').after(featureStep);
                });
                numberedStepper.next();
                console.log('next')
            }else{
                e.preventDefault();
            }
        });
        $(horizontalWizard).find('.btn-prev').on('click', function () {
            numberedStepper.previous();
        });

        $(horizontalWizard).find('.btn-submit').on('click', function () {
            var isValid = $(this).parent().siblings('form').valid();
            if (isValid) {
                alert('inspection-wizard Submitted..!!');
            }
        });
    }

    function projectProductLabels(project, product){
        $('.project_name').each(function(){
            $(this).append(project)
        });
        $('.product_name').each(function(){
            $(this).append(product)
        })
    }
    function queryFeatures(ids, pdf){
        $.ajax({
            url: "{{route('product.feature')}}",
            type: 'POST',
            data: {
                features: ids,
            },
            success: function(response){
                if(response){
                    return response;
                    // $('.feature_names').each(function(){
                    //     $(this).append(response.join(','))
                    // })
                }
            }
        })
    }
    function queryProduct (partnumber_value){
        let isNotEmpty;
        $.ajax({
            url: "{{route('product.partnumber')}}",
            type: "POST",
            async: false,
            data: {
                part_no: partnumber_value
            },
            success: function(e){
                queryData = e;
                if((jQuery.isEmptyObject( e ) != true)){
                    isNotEmpty = true;
                    $('#controlplan-revision embed').attr('src', (e.work_instruction.files))
                }else{
                    $('#part_number').addClass('error');
                    $('#partnumber form').validate().showErrors({
                        partnumber: 'Product not found. Please create product before you start.'
                    });
                    isNotEmpty = false;
                }
            }
        });
        return isNotEmpty;
    }
</script>
@endsection
