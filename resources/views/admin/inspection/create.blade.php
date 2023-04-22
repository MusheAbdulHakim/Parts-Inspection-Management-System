@extends('layouts.contentLayoutMaster')

@section('title', 'New Inspection')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/custom-wizard.css')}}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@section('content')
<div class="container">
    <div class="panel">
        <div class="panel-body wizard-content">
            <div class="d-flex justify-content-end align-items-end d-none">Control Plan: <b id="control_plan" class="ms-1"> </b></div>
            <div id="wizard-form" action="#" class="tab-wizard wizard-circle wizard clearfix">
                <h6>1</h6>
                <section>
                    <form id="form-1">
                        <div class="row">
                            <div class="mb-1">
                                <label for="user_name">UserName</label>
                                <input type="text" disabled value="{{ auth()->user()->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="mb-1">
                                    <label class="form-label" for="part_number">Please Scan Part Number</label>
                                    <input type="text" name="partnumber" autofocus id="part_number" class="form-control"
                                        placeholder="Enter Part Number" required />
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

                <h6>2</h6>
                <section></section>

            </div>
        </div>
    </div>
</div>
@endsection


@section('vendor-script')
  <script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendors/js/jquery-steps/jquery.steps.min.js')}}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
            $('#control_method1').summernote('disable');
            if ($('.position-select').length > 0) {
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
    <script src="{{ asset('summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $(document).ready(function(){
            let wizard = $("#wizard-form");
            let productData;
            wizard.steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span>',
                onStepChanging: beforeStepChange
            });

            $('#wizard-form').find('form').each(function(){
                $(this).validate({
                    rules: {
                        partnumber: {
                            required: true
                        }
                    }
                });
            })

        });



        function beforeStepChange(event, currentIndex, newIndex){
            if (currentIndex > newIndex)
            {
                return true;
            }


            if((currentIndex === 0) && (newIndex === 1)){
                var partnumber = $('#part_number').val();
                var isEmptyResponse = getProductData(partnumber);
                if ((isEmptyResponse === true) || !productData) {
                    $('#form-1').validate().showErrors({
                        partnumber: 'Product not found. Please create product before you start.'
                    });
                    return false;
                }else{
                    $('#control_plan').parent().removeClass('d-none');
                    $('#control_plan').html(productData.control_plan)
                    var $form2 = `
                    <form id="form-2" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-8">
                                <embed src="${productData.work_instruction.files}" width="100%" height="400" />
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="mb-1">
                                        <label>Project: <b>${productData.project_name}</b></label>
                                    </div>
                                    <div class="mb-1">
                                        <label>Product: <b>${productData.product.part_no}</b></label>
                                    </div>
                                    <div class="mb-1">
                                        <label for="batch_no">Batch Number</label>
                                        <input type="text" placeholder="Enter Batch Number" class="form-control" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide Batch Number.
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="quantity">Quantity</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" required/>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide Quantity.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>`;
                    $('#wizard-form').steps("insert",1, {
                        content: $form2,
                    });
                    return true;
                }

            }
            if((currentIndex === 1) && productData){
                getFeatures(productData.features).then(function(response) {
                    if(response){
                        var insertion_point = 2;
                        $.each(response, function(index, feature) {
                            var $form3 = `
                                <form id="form-${insertion_point}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <embed src="${productData.work_instruction.files}" width="100%" height="375" />
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="mb-1">
                                                    <label>Project: <b>${productData.project_name}</b></label>
                                                </div>
                                                <div class="mb-1">
                                                    <label>Product: <b>${productData.product.part_no}</b></label>
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
                                </form>`;
                                // $('#wizard-form').steps("add",{
                                //     content: $form3,
                                // });
                                $('#wizard-form').steps("insert",insertion_point, {
                                    content: $form3,
                                });
                            insertion_point++;
                        });

                        $('.summernote').each(function(){
                            $(this).summernote('disable');
                        });

                    }
                }).catch(function(error) {
                    console.error(error);
                });
            }

            return true;
        }


        function queryProduct (partnumber_value){
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: "{{route('product.partnumber')}}",
                    type: 'POST',
                    data: {
                        part_no: partnumber_value
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        reject(errorThrown);
                    }
                });
            });
        }

        function getProductData (partnumber_value){
            let isNotEmpty;
            $.ajax({
                url: "{{route('product.partnumber')}}",
                type: "POST",
                async: false,
                data: {
                    part_no: partnumber_value
                },
                success: function(e){
                    productData = e;
                    isNotEmpty = jQuery.isEmptyObject(e)
                }
            });
            return isNotEmpty;
        }

        function getFeatures(ids) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                url: "{{route('product.feature')}}",
                type: 'POST',
                data: {
                    features: ids,
                },
                success: function(response) {
                    resolve(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    reject(errorThrown);
                }
                });
            });
        }

    </script>
@endsection
