@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection
@section('style')
  <style>
      .w-50{
        width: 50%;
      }
      .enter_number, .d-none{
        display: none;
      }
      .random_coupon{
        cursor: pointer;
      }
  </style>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $module_name }}
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Add')</a>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @if (session('errorMessage'))
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('errorMessage') }}
            </div>
        @endif
        @if (session('successMessage'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{ session('successMessage') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

            </div>
        @endif
        <form role="form"action="{{ route(Request::segment(2) . '.update', $detail->id) }}" method="POST" id="form_discount">
            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Update form')</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->

                        @csrf
                        @method('PUT')
                        <div class="box-body">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">
                                            <h5>Thông tin chính <span class="text-danger">*</span></h5>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="d-flex-wap">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Name') <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="@lang('Name Coupon')" value="{{ $detail->name }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Create coupon code') <small class="text-red">*</small></label>
                                                    <a class="pull-right random_coupon">@lang('Random coupon code') </a>
                                                    <input type="text" class="form-control coupon_code" name="coupon_code"
                                                        placeholder="@lang('Customers will enter this coupon code when they checkout.')" value="{{ $detail->coupon_code }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type='hidden' value='' name='is_unlimited'>
                                                <input type="checkbox" id="unlimited" name="is_unlimited" {{ $detail->is_unlimited=="unlimited"? "checked":""}}  value="unlimited">
                                                <label for="unlimited">@lang('Unlimited coupon') </label>
                                            </div>

                                            <div class="col-md-12 is_unlimited_block {{ $detail->is_unlimited=="unlimited"? "enter_number":""}}">
                                                <div class="form-group">
                                                    <label>@lang('Enter quantity') </label>
                                                    <input type="number" required {{ $detail->is_unlimited=="unlimited"? "disabled":""}} class="form-control w-50 coupon_quantity" value="{{ $detail->is_unlimited=="unlimited"? "":$detail->coupon_quantity}}" name="coupon_quantity">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr style="border-top: dashed 2px #a94442; margin: 10px 0px;">
                                            </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>@lang('Coupon type')  <small class="text-red">*</small></label>
                                                    <select required style="width: 100%;" name="coupon_type" class=" form-control select2 ">
                                                        @foreach (App\Consts::TYPE_DISCOUNT as $k=>$val)
                                                            <option {{ $detail->coupon_type==$k? "selected":""}} value="{{ $k }}" >@lang($val)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label>@lang('Discount')  <small class="text-red">*</small></label>
                                                    <input type="number" name="discount" class="form-control"  value="{{ $detail->discount??1 }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 "> 
                                                <div class="form-group">
                                                    <label>@lang('Apply for')  <small class="text-red">*</small></label>
                                                    <select style="width: 100%;" name="apply_for" class="apply_for form-control select2">
                                                        @foreach (App\Consts::APPLY_FOR as $k=>$val)
                                                            <option {{ $detail->apply_for==$k? "selected":""}} value="{{ $k }}" >@lang($val)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none amount-minimum-order apply_list">
                                                <label>@lang('Order amount from')  </label> 
                                                <div class="form-group">
                                                    <input type="text" value="{{ $detail->amount_minimum_order }}" required name="amount_minimum_order" class="form-control" disabled>
                                                </div>
                                            </div>
                                            @php
                                                $arr_specific_product=explode(',', $detail->specific_product);
                                                $arr_category_product=explode(',', $detail->category_product);
                                                $arr_customer=explode(',', $detail->customer);
                                            @endphp
                                            <div class="col-md-6 d-none specific-product apply_list">
                                                <label>@lang('Select Product')  </label> 
                                                <div class="form-group">
                                                    <select disabled required style="width: 100%;" multiple name="specific_product[]" class="form-control select2">
                                                        @foreach($product as $pro)
                                                            <option {{ in_array($pro->id, $arr_specific_product)?"selected":"" }} value="{{ $pro->id }}">{{ $pro->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none category-product apply_list">
                                                <label>@lang('Category product')  </label> 
                                                <div class="form-group">
                                                    <select disabled required  style="width: 100%;" multiple name="category_product[]" class="form-control select2">
                                                        @foreach($category as $cate)
                                                            <option {{ in_array($cate->id, $arr_category_product)?"selected":"" }} value="{{ $cate->id }}">{{ $cate->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none customer apply_list">
                                                <label>@lang('Customers')  </label>
                                                <div class="form-group"> 
                                                    <select disabled required style="width: 100%;" multiple name="customer[]" class="form-control select2">
                                                        @foreach($user_list as $us)
                                                            <option {{ in_array($us->id, $arr_customer)?"selected":"" }} value="{{ $us->id }}">{{ $us->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.tab-content -->
                            </div><!-- nav-tabs-custom -->

                        </div>
                        <!-- /.box-body -->


                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Publish')</h3>
                        </div>
                        <div class="box-body">
                            <div class="btn-set">
                                <button type="submit" class="btn btn-info submit_form">
                                    <i class="fa fa-save"></i> @lang('Save')
                                </button>
                                &nbsp;&nbsp;
                                <a class="btn btn-success " href="{{ route(Request::segment(2) . '.index') }}">
                                    <i class="fa fa-bars"></i> @lang('List')
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Status')</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select name="status" class=" form-control select2">
                                    @foreach ($status as $key => $val)
                                        <option value="{{ $key }}"
                                            {{ ( $detail->status == $key) ? 'selected' : '' }}>
                                            @lang($val)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                   
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Start date') <small class="text-red">*</small></h3>
                        </div>
                        <div class="box-body">
                            @php
                            $dts = new DateTime;
                            $dte = new DateTime;
                            $dts->setTime(0, 0);
                            $dte->setTime(23, 59);
                            @endphp
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="datetime-local" required class="form-control" name="time_start" value="{{ $detail->time_start ?? $dts->format('Y-m-d\TH:i:s')}}">
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('End date')</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input required {{ $detail->never_expired==1? "disabled":""}} type="datetime-local" class="form-control end_time" name="time_end" value="{{ $detail->time_end ?? $dte->format('Y-m-d\TH:i:s')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box box-primary">
                        <div class="box-body"> 
                            <input type="hidden" name="never_expired" value=""> 
                            <input type="checkbox" value="1" name="never_expired" {{ $detail->never_expired==1 ? "checked":""}}  id="never_expired">    
                            <label >@lang('Never expired')</label>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

@endsection

@section('script')
    <script>
    $(document).ready(function(){
        $('.apply_for').trigger('change');
    })
    $("#form_discount").validate({
        errorPlacement: function (error, element) {
            error.appendTo(element.parents(".form-group"));
            error.wrap("<label class='text-red '>");
        },
        rules: {
            'coupon_quantity': {
                required:true,
                min:1
            },
            'discount': {
                required:true,
                min:1
            },
            'amount-minimum-order': {
                required:true,
                min:1
            },
        },
        
    });    
    function randoms(length = 8){
        let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let str = '';
        for (let i = 0; i < length; i++) {
            str += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return str;
    }
    $('.random_coupon').click(function(){
        var random=randoms(10);
        $('.coupon_code').val(random);
    })
     $('#unlimited').click(function(){
        if($(this).is(':checked')) {
            $(".is_unlimited_block").addClass('enter_number');
            $(".coupon_quantity").prop('disabled', true);
        }
        else { 
            $(".is_unlimited_block").removeClass('enter_number');
            $(".coupon_quantity").prop('disabled', false);
        }
    })
    $('#never_expired').click(function(){
        if($(this).is(':checked')) 
            $(".end_time").prop('disabled', true);
        else $(".end_time").prop('disabled', false);
    })
    $('.apply_for').change(function(){
        $('.apply_list').hide();
        $('.apply_list input').prop('disabled', true);
        $('.apply_list select').prop('disabled', true);
        var value=$(this).val();
        if(value=='amount-minimum-order') {
            $('.amount-minimum-order').show();
            $('.amount-minimum-order input').prop('disabled', false);
        }
        if(value=='specific-product'){
            $('.specific-product').show();
            $('.specific-product select').prop('disabled', false);
        } 
        if(value=='category-product'){
            $('.category-product').show();
            $('.category-product select').prop('disabled', false);
        } 
        if(value=='customer'){
            $('.customer').show();
            $('.customer select').prop('disabled', false);
        } 
    })
    </script>
@endsection
