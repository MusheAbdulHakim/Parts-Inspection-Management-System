@extends('layouts.contentLayoutMaster')

@section('title', 'View Inspection')

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}">
<link rel="stylesheet" href="{{asset('css/base/plugins/forms/custom-wizard.css')}}">
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <style>
        embed {
            height: 100vh !important;
        }
        .wrapper{
            display: inline-flex;
            background: #fff;
            height: 100px;
            width: 400px;
            align-items: center;
            justify-content: space-evenly;
            border-radius: 5px;
            padding: 20px 15px;
        }
        .wrapper .option{
            background: #fff;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            margin: 0 10px;
            border-radius: 5px;
            cursor: pointer;
            padding: 0 10px;
            border: 2px solid lightgrey;
            transition: all 0.3s ease;
        }
        .wrapper .option .dot{
            height: 20px;
            width: 20px;
            background: #d9d9d9;
            border-radius: 50%;
            position: relative;
        }
        .wrapper .option .dot::before{
            position: absolute;
            content: "";
            top: 4px;
            left: 4px;
            width: 12px;
            height: 12px;
            background: #0069d9;
            border-radius: 50%;
            opacity: 0;
            transform: scale(1.5);
            transition: all 0.3s ease;
        }
        input[type="radio"]{
            display: none;
        }
        #option-1:checked:checked ~ .option-1,
        #option-2:checked:checked ~ .option-2{
            border-color: #0069d9;
            background: #0069d9;
        }
        #option-1:checked:checked ~ .option-1 .dot,
        #option-2:checked:checked ~ .option-2 .dot{
            background: #fff;
        }
        #option-1:checked:checked ~ .option-1 .dot::before,
        #option-2:checked:checked ~ .option-2 .dot::before{
            opacity: 1;
            transform: scale(1);
        }
        .wrapper .option span{
            font-size: 20px;
            color: #fff;
        }
        #option-1:checked:checked ~ .option-1 span,
        #option-2:checked:checked ~ .option-2 span{
            color: #fff;
        }
    </style>
@endsection

@section('content')
<div class="panel">
    <div class="panel-body wizard-content">
        <div class="d-flex justify-content-end align-items-end m-1 d-none">Control Plan: <b id="control_plan" class="ms-1"> </b></div>
        <form action="{{route('inspections.index')}}" method="get" id="main-form">
            @csrf
            <input type="hidden" name="quantity" id="m-quantity">
            <input type="hidden" name="batch_no" id="m-batch_no">
            <input type="hidden" name="measure_value" id="m-measure_value">
            <div id="wizard-form" action="#" class="tab-wizard wizard-circle wizard clearfix">
                <h6>1</h6>
                <section>
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
                                <input type="text" readonly name="partnumber" autofocus id="part_number" class="form-control"
                                    placeholder="Enter Part Number" required value="{{$inspection->partnumber}}" />
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</div>
@endsection


@section('vendor-script')
    <script src="{{asset('vendors/js/jquery-steps/jquery.steps.min.js')}}"></script>
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.summernote').summernote();
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
            let wizard = $("#wizard-form");
            let productData;
            var isComplete;
            wizard.steps({
                headerTag: "h6",
                bodyTag: "section",
                transitionEffect: "fade",
                titleTemplate: '<span class="step">#index#</span>',
                onStepChanging: beforeStepChange,
                onFinishing: beforeFinishing,
                onFinished: function (event, currentIndex) {
                    if (currentIndex == 3){
                        var measure_values = []
                        $('#main-form').find('form').each(function(){
                            var measure_val = $(this).find("input[name='measure_value[]']").val()
                            if (measure_val){
                                measure_values.push(measure_val)
                            }
                        })
                        $('#m-quantity').val($('#quantity').val())
                        $('#m-batch_no').val($('#batch_no').val())
                        $('#m-measure_value').val(measure_values)
                        window.location.href="{{route('inspections.index')}}"
                    }
                }
            });

        });

        function beforeStepChange(event, currentIndex, newIndex){
            $('#wizard-form').find('form').each(function(){
                $(this).validate({
                    rules: {
                        partnumber: {
                            required: true
                        },
                        batch_no: {
                            required: true
                        },
                        quantity: {
                            required: true
                        }
                    }
                });
            })
            if (currentIndex > newIndex)
            {
                return true;
            }
            return true;
        }

        function beforeFinishing(event, currentIndex){
            if(currentIndex == 0){
                var partnumber = $('#part_number').val();
                var isEmptyResponse = getProductData(partnumber);
                if ((isEmptyResponse === true) || !productData) {
                    $('#main-form').validate().showErrors({
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
                                        <input type="text" placeholder="Enter Batch Number" class="form-control" readonly name="batch_no" value="{{$inspection->batch_no ?? ''}}" id="batch_no" required>
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="quantity">Quantity</label>
                                        <input type="number" id="quantity" name="quantity" class="form-control" readonly placeholder="Enter Quantity" value="{{$inspection->quantity ?? 1}}" required/>
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
                        var insertion_point = 3;
                        var default_measure_values = "{{implode(',',$inspection->measure_values)}}";
                        var measure_value_arr = default_measure_values.split(',')
                        var default_binary = "{{!empty($inspection->extra_data['binary_values']) ? implode(',',$inspection->extra_data['binary_values']): ''}}"
                        var binary_arr = default_binary.split(',')
                        $.each(response, function(index, feature) {
                            var $form3 = `
                                <form id="form-${insertion_point}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <embed src="${productData.work_instruction.files}" width="100%" height="400" />
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
                                                <div class="number_feature ${(feature.type != 'number') ? 'd-none': ''}">
                                                    ${((feature.tool != null) && (feature.tool != '')) ?
                                                    `
                                                    <div class="mb-1">
                                                        <div class="col-12">
                                                            <label for="tool" class="form-label">Inspection Tool</label>
                                                            <div class="choose-position">
                                                                <select readonly data-placeholder="Select Inspection Tool" name="tool" id="tool-${index}" class="form-control position-select">
                                                                    <option value="">${feature.tool}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>`:
                                                    ``}
                                                    <div class="mb-1">
                                                        <div class="col-12">
                                                            <label class="form-label" for="target">Target</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                id="target-${index}"
                                                                name="target"
                                                                value="${feature.target}"
                                                                class="form-control"
                                                                placeholder="Target"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <div class="col-12">
                                                            <label class="form-label" for="upper">Upper Limit</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                id="upper-${index}"
                                                                name="upper_limit"
                                                                value="${feature.upper_limit}"
                                                                class="form-control"
                                                                placeholder="Upper Limit"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="mb-1">
                                                        <div class="col-12">
                                                            <label class="form-label" for="lower">Lower Limit</label>
                                                            <input
                                                                readonly
                                                                type="text"
                                                                id="lower-${index}"
                                                                name="lower_limit"
                                                                value="${feature.lower_limit}"
                                                                class="form-control"
                                                                placeholder="Lower Limit"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-1">
                                                    <div class="col-12">
                                                    <label class="form-label">Control Method</label>
                                                    <textarea class="form-control summernote"
                                                    placeholder="Control Method" id="control_method${index}" cols="3" rows="3">${feature.control_method}</textarea>
                                                    </div>
                                                </div>
                                                ${((feature.type != 'binary') && (feature.tool != null)) ?
                                                    `<div class="mb-1">
                                                        <label for="batch_no">Control Tool</label>
                                                        <input type="text" readonly value="${feature.tool}" class="form-control">
                                                    </div>
                                                    <div class="mb-1">
                                                        <label class="form-label">Measure Value</label>
                                                        <input type="text" name="measure_value[]" value="${measure_value_arr}" class="form-control" placeholder="Enter Measure value" />
                                                    </div>`
                                                    :
                                                    `
                                                    <div class="wrapper">
                                                        <input type="radio" name="pass" onclick="setChecked('#option-1','#option-2')" id="option-1" ${binary_arr == 'pass' ? 'checked':''}>
                                                        <input type="radio" name="fail" onclick="setChecked('#option-2','#option-1')" id="option-2" ${binary_arr == 'fail' ? 'checked':''}>
                                                        <label for="option-1" class="option option-1 bg-success">
                                                            <div class="dot"></div>
                                                            <span>Pass</span>
                                                        </label>
                                                        <label for="option-2" class="option option-2 bg-danger">
                                                            <div class="dot"></div>
                                                            <span>Fail</span>
                                                        </label>
                                                    </div>
                                                    `
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </form>`;

                                $('#wizard-form').steps("add",{
                                    content: $form3,
                                });
                            insertion_point++;
                        });
                        $('.summernote').each(function(){
                            $(this).summernote({
                                height: 200,
                            });
                            $(this).summernote('disable');
                        });
                    }
                }).catch(function(error) {
                    console.error(error);
                });
            }
            return true;
        }


        function setChecked(first,second){
            $(first).prop("checked", true);
            $(second).prop("checked", false);
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
