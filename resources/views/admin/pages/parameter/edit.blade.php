@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection
@section('style')
    <style>
        .select2-container {
            width: 100% !important;
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
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}">
                <i class="fa fa-plus"></i> @lang('Add')
            </a>
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">@lang('Update form')</h3>
                @isset($languages)
                <div class="collapse navbar-collapse pull-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-language"></i>
                                {{ Request::get('lang') && Request::get('lang') != $languageDefault->lang_code ? $languages->first(function ($item, $key) use ($lang) {
                                    return $item->lang_code == $lang;
                                })['lang_name'] : $languageDefault->lang_name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @isset($languages)
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
                                @endisset
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
                                <h5>
                                    @lang('General information')
                                    <span class="text-danger">*</span>
                                </h5>
                            </a>
                        </li>
                        <a class="btn btn-success btn-sm pull-right" href="{{ route(Request::segment(2) . '.index') }}">
                            <i class="fa fa-bars"></i>
                            @lang('List')
                        </a>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <!-- form start -->
                            <form role="form" action="{{ route(Request::segment(2) . '.update', $detail->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                @if (Request::get('lang') != '' && Request::get('lang') != $languageDefault->lang_locale)
                                    <input type="hidden" name="lang" value="{{ Request::get('lang') }}">
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('Title')
                                                <small class="text-red">*</small>
                                            </label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="@lang('Title')" value="{{ $detail->json_params->name->$lang??$detail->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Status')</label>
                                            <div class="form-control">
                                                @foreach (App\Consts::STATUS as $key => $value)
                                                    <label>
                                                        <input type="radio" name="status" value="{{ $value }}"
                                                            {{ $detail->status == $value ? 'checked' : '' }}>
                                                        <small class="mr-15">{{ __($value) }}</small>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Order')</label>
                                            <input type="number" class="form-control" name="iorder"
                                                placeholder="@lang('Order')" value="{{ $detail->iorder }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-floppy-o"></i>
                                            @lang('Save')
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr style="border-top: dashed 2px #a94442; margin: 10px 0px;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">@lang('Add new item')</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="the-box ">
                                                <form action="{{ route(Request::segment(2) . '.store') }}" method="POST"
                                                    id="form-main">
                                                    @csrf
                                                    @if (Request::get('lang') != '' && Request::get('lang') != $languageDefault->lang_locale)
                                                        <input type="hidden" name="lang"
                                                            value="{{ Request::get('lang') }}">
                                                    @endif
                                                    <div class="d-flex-wap">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>
                                                                    @lang('Title')
                                                                    <small class="text-red">*</small>
                                                                </label>
                                                                <input type="text" class="form-control" name="name"
                                                                    placeholder="@lang('Title')"
                                                                    value="{{ old('name') ?? '' }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('Status')</label>
                                                                <div class="form-control">
                                                                    <label>
                                                                        <input type="radio" name="status"
                                                                            value="active" checked>
                                                                        <small class="mr-15">@lang('active')</small>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="status"
                                                                            value="deactive">
                                                                        <small class="mr-15">@lang('deactive')</small>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>@lang('Value')</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="@lang('Value')"
                                                                    value="{{ old('propety_value') }}"
                                                                    name="propety_value">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>@lang('Image')</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn">
                                                                        <a data-input="image" data-preview="image-holder"
                                                                            class="btn btn-primary lfm"
                                                                            data-type="cms-images">
                                                                            <i class="fa fa-picture-o"></i>
                                                                            @lang('choose')
                                                                        </a>
                                                                    </span>
                                                                    <input id="image" class="form-control"
                                                                        type="text" name="image"
                                                                        placeholder="@lang('image_link')..."
                                                                        value="{{ $detail->image }}">
                                                                </div>
                                                                <div id="image-holder"
                                                                    style="margin-top:15px;max-height:100px;">
                                                                    @if ($detail->image != '')
                                                                        <img style="height: 5rem;"
                                                                            src="{{ $detail->image }}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-end col-md-6">
                                                            <div class="btn-group btn-group-devided">
                                                                <input type="hidden" name="parent_id"
                                                                    value="{{ $detail->id }}">
                                                                <input type="hidden" name="is_type"
                                                                    value="{{ $detail->is_type }}">
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm submit_form">
                                                                    <i class="fa fa-floppy-o"></i>
                                                                    @lang('Add new')
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    @if (isset($items) && count($items) > 0)
                                        <div class="row">
                                            <div class="col-md-12 mt-md-10">
                                                <div class="box box-primary">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">
                                                            @lang('List items')
                                                        </h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="table-responsive">
                                                            <div class="dd" id="menu-sort">
                                                                <ol class="dd-list">
                                                                    @foreach ($items as $item)
                                                                        <li class="dd-item dd3-item "
                                                                            data-id="{{ $item->id }}">
                                                                            <div class="dd-handle dd3-handle"></div>
                                                                            <div class="dd3-content">
                                                                                <span class="text float-start"
                                                                                    data-update="title">{{ $item->json_params->name->$lang??$item->name }}</span>
                                                                                <span class="text float-end"></span>
                                                                                <a data-toggle="collapse"
                                                                                    href="#item-details-{{ $item->id }}"
                                                                                    role="button" aria-expanded="false"
                                                                                    aria-controls="item-details-{{ $item->id }}"
                                                                                    class="show-item-details">
                                                                                    <i class="fa fa-angle-down"></i>
                                                                                </a>
                                                                                <div class="clearfix"></div>
                                                                            </div>

                                                                            <div class="item-details collapse multi-collapse"
                                                                                id="item-details-{{ $item->id }}">

                                                                                <form role="form"
                                                                                    action="{{ route(Request::segment(2) . '.update', $item->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    @if (Request::get('lang') != '' && Request::get('lang') != $languageDefault->lang_locale)
                                                                                        <input type="hidden"
                                                                                            name="lang"
                                                                                            value="{{ Request::get('lang') }}">
                                                                                    @endif
                                                                                    <input type="hidden" name="parent_id"
                                                                                        value="{{ $detail->id }}">
                                                                                    <input type="hidden" name="is_type"
                                                                                        value="{{ $detail->is_type }}">
                                                                                    <div class="box-body">

                                                                                        <div class="d-flex-wap">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label>
                                                                                                        @lang('Title')
                                                                                                        <small
                                                                                                            class="text-red">*</small>
                                                                                                    </label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        name="name"
                                                                                                        placeholder="@lang('Title')"
                                                                                                        value="{{ old('title') ?? ($item->json_params->name->$lang??$item->name) }}"
                                                                                                        required>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label>@lang('Status')</label>
                                                                                                    <div
                                                                                                        class="form-control">
                                                                                                        <label>
                                                                                                            <input
                                                                                                                type="radio"
                                                                                                                name="status"
                                                                                                                value="active"
                                                                                                                {{ $item->status == 'active' ? 'checked' : '' }}>
                                                                                                            <small
                                                                                                                class="mr-15">@lang('active')</small>
                                                                                                        </label>
                                                                                                        <label>
                                                                                                            <input
                                                                                                                type="radio"
                                                                                                                name="status"
                                                                                                                value="deactive"
                                                                                                                {{ $item->status == 'deactive' ? 'checked' : '' }}>
                                                                                                            <small
                                                                                                                class="mr-15">@lang('deactive')</small>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <div class="form-group">
                                                                                                    <label>@lang('Value')</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        placeholder="@lang('Value')"
                                                                                                        value="{{ $item->propety_value ?? old('propety_value') }}"
                                                                                                        name="propety_value">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label>@lang('Image')</label>
                                                                                                    <div
                                                                                                        class="input-group">
                                                                                                        <span
                                                                                                            class="input-group-btn">
                                                                                                            <a data-input="image-{{ $item->id }}"
                                                                                                                data-preview="image-holder-{{ $item->id }}"
                                                                                                                class="btn btn-primary lfm"
                                                                                                                data-type="cms-images">
                                                                                                                <i
                                                                                                                    class="fa fa-picture-o"></i>
                                                                                                                @lang('choose')
                                                                                                            </a>
                                                                                                        </span>
                                                                                                        <input
                                                                                                            id="image-{{ $item->id }}"
                                                                                                            class="form-control"
                                                                                                            type="text"
                                                                                                            name="image"
                                                                                                            placeholder="@lang('image_link')..."
                                                                                                            value="{{ $item->image }}">
                                                                                                    </div>
                                                                                                    <div id="image-holder-{{ $item->id }}"
                                                                                                        style="margin-top:15px;max-height:100px;">
                                                                                                        @if ($item->image != '')
                                                                                                            <img style="height: 5rem;"
                                                                                                                src="{{ $item->image }}">
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                                    <div class="text-end mt-2">
                                                                                        <button
                                                                                            class="btn btn-primary btn-sm">@lang('Save')</button>
                                                                                        <p class="btn btn-danger remove_menu btn-sm"
                                                                                            data-id="{{ $item->id }}">
                                                                                            Remove </p>
                                                                                    </div>
                                                                                </form>

                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="box-footer">
                                                        <a class="btn btn-warning btn-flat menu-sort-save btn-sm"
                                                            title="@lang('Save')">
                                                            <i class="fa fa-floppy-o"></i>
                                                            @lang('Save sort')
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">

                </div>

            </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#menu-sort').nestable({
                group: 0,
                maxDepth: 1,
            });
        });
        $('.menu-sort-save').click(function() {
            $('#loading').show();
            let serialize = $('#menu-sort').nestable('serialize');
            let menu = JSON.stringify(serialize);
            $.ajax({
                    url: '{{ route('parameter.update_sort') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        menu: menu,
                        root_id: {{ $detail->id }}
                    },
                })
                .done(function(data) {
                    $('#loading').hide();
                    if (data.error == 0) {
                        location.reload();
                    } else {
                        alert(data.msg);
                        location.reload();
                    }
                });
        });
        $('.remove_menu').click(function() {
            if (confirm("@lang('confirm_action')")) {
                let _root = $(this).closest('.dd-item');
                let id = $(this).data('id');
                $.ajax({
                    method: 'post',
                    url: '{{ route('parameter.delete') }}',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        if (data.error == 1) {
                            alert(data.msg);
                        } else {
                            _root.remove();
                        }
                    }
                });
            }
        });
    </script>
@endsection
