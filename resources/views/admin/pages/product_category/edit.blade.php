@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection
@section('style')
    <style>
        .checkbox_list {
            min-height: 300px;
        }
    </style>
@endsection
@php
    if (Request::get('lang') == $languageDefault->lang_locale || Request::get('lang') == '') {
        $lang = $languageDefault->lang_locale;
    } else {
        $lang = Request::get('lang');
    }
@endphp
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
        <form role="form" onsubmit=" return check_nestb()"
            action="{{ route(Request::segment(2) . '.update', $detail->id) }}" method="POST">
            @csrf
            @method('PUT')
            @if (Request::get('lang') != '' && Request::get('lang') != $languageDefault->lang_locale)
                <input type="hidden" name="lang" value="{{ Request::get('lang') }}">
            @endif
            @php
                $route = $detail->json_params->route_name ?? 'product.category';
                $route_default = collect($route_name)->first(function ($item, $key) use ($route) {
                    return $item['name'] == $route;
                });
            @endphp
            @if ($route_default)
                <input type="hidden" name="json_params[route_name]" value="{{ $route_default['name'] }}">
            @endif


            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Update form')</h3>
                            @isset($languages)
                                <div class="collapse navbar-collapse pull-right">
                                    <ul class="nav navbar-nav">
                                        <li class="dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-language"></i>
                                                {{ Request::get('lang') && Request::get('lang') != $languageDefault->lang_code
                                                    ? $languages->first(function ($item, $key) use ($lang) {
                                                        return $item->lang_code == $lang;
                                                    })['lang_name']
                                                    : $languageDefault->lang_name }}
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                @foreach ($languages as $item)
                                                    @if ($item->lang_code != $languageDefault->lang_code)
                                                        <li>
                                                            <a href="{{ route(Request::segment(2) . '.edit', $detail->id) }}?lang={{ $item->lang_locale }}"
                                                                style="padding-top:10px; padding-bottom:10px;">
                                                                <i class="fa fa-language"></i>
                                                                {{ $item->lang_name }}
                                                            </a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ route(Request::segment(2) . '.edit', $detail->id) }}"
                                                                style="padding-top:10px; padding-bottom:10px;">
                                                                <i class="fa fa-language"></i>
                                                                {{ $item->lang_name }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <span class="pull-right" style="padding: 15px">@lang('Translations'): </span>
                            @endisset
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">
                                            <h5>Thông tin chính <span class="text-danger">*</span></h5>
                                        </a>
                                    </li>

                                    <button type="submit" class="btn btn-primary btn-sm pull-right">
                                        <i class="fa fa-floppy-o"></i>
                                        @lang('Save')
                                    </button>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Title') <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="@lang('Title')"
                                                        value="{{ $detail->json_params->name->$lang ?? $detail->name }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>URL tùy chọn</label>
                                                    <i class="fa fa-coffee text-red" aria-hidden="true"></i>
                                                    <small class="form-text">
                                                        (
                                                        <i class="fa fa-info-circle"></i>
                                                        Maximum 100 characters in the group: "A-Z", "a-z", "0-9" and
                                                        "-_" )
                                                    </small>
                                                    <input name="alias" class="form-control"
                                                        value="{{ $detail->alias ?? old('alias') }}" />
                                                </div>


                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Brief')</label>
                                                    <textarea name="json_params[brief][{{ $lang }}]" class="form-control" rows="5">{{ $detail->json_params->brief->$lang ?? old('json_params[brief][' . $lang . ']') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Description')</label>
                                                    <textarea name="json_params[description][{{ $lang }}]" class="form-control" rows="5">{{ $detail->json_params->description->$lang ?? old('json_params[description][' . $lang . ']') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>@lang('Content')</label>
                                                        <textarea name="json_params[content][{{ $lang }}]" class="form-control" id="content_vi">{{ $detail->json_params->content->$lang ?? old('json_params[content][' . $lang . ']') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('seo_title')</label>
                                                    <input name="json_params[seo_title][{{ $lang }}]"
                                                        class="form-control"
                                                        value="{{ $detail->json_params->seo_title->$lang ?? old('json_params[seo_title][' . $lang . ']') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('seo_keyword')</label>
                                                    <input name="json_params[seo_keyword][{{ $lang }}]"
                                                        class="form-control"
                                                        value="{{ $detail->json_params->seo_keyword->$lang ?? old('json_params[seo_keyword][' . $lang . ']') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('seo_description')</label>
                                                    <input name="json_params[seo_description][{{ $lang }}]"
                                                        class="form-control"
                                                        value="{{ $detail->json_params->seo_description->$lang ?? old('json_params[seo_description][' . $lang . ']') }}">
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
                @include('admin.pages.includes.slide_taxonomy')
            </div>
        </form>
    </section>
@endsection

@section('script')
    <script>
        CKEDITOR.replace('content_vi', ck_options);
        $(document).ready(function() {
            var no_image_link = '{{ url('themes/admin/img/no_image.jpg') }}';
            $('.inp_hidden').on('change', function() {
                $(this).parents('.box_img_right').addClass('active');
            });

            $('.box_img_right').on('click', '.btn-remove', function() {
                let par = $(this).parents('.box_img_right');
                par.removeClass('active');
                par.find('img').attr('src', no_image_link);
                par.find('input[type=hidden]').val("");
            });
            // Routes get all
            var routes = @json(App\Consts::ROUTE_NAME ?? []);
            $(document).on('change', '#route_name', function() {
                let _value = $(this).val();
                let _targetHTML = $('#template');
                let _list = filterArray(routes, 'name', _value);
                let _optionList = '<option value="">@lang('Please select')</option>';
                if (_list) {
                    _list.forEach(element => {
                        element.template.forEach(item => {
                            _optionList += '<option value="' + item.name + '"> ' + item
                                .title + ' </option>';
                        });
                    });
                    _targetHTML.html(_optionList);
                }
                $(".select2").select2();
            });
        });
    </script>
@endsection
