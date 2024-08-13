@extends('admin.layouts.app')

@section('title')
    {{ $module_name }}
@endsection
@php
    if (Request::get('lang') == $languageDefault->lang_locale || Request::get('lang') == '') {
        $lang = $languageDefault->lang_locale;
    } else {
        $lang = Request::get('lang');
    }
@endphp
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $module_name }}
            <a class="btn btn-sm btn-warning pull-right" href="{{ route(Request::segment(2) . '.create') }}"><i
                    class="fa fa-plus"></i> @lang('Add')</a>
        </h1>
    </section>
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        {{-- Search form --}}
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title">@lang('Filter')</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form action="{{ route(Request::segment(2) . '.index') }}" method="GET">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Keyword') </label>
                                <input type="text" class="form-control" name="keyword" placeholder="@lang('keyword_note')"
                                    value="{{ isset($params['keyword']) ? $params['keyword'] : '' }}">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('Post category')</label>
                                <select name="taxonomy_id" id="taxonomy_id" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($parents as $item)
                                        @if ($item->parent_id == 0 || $item->parent_id == null)
                                            <option value="{{ $item->id }}"
                                                {{ isset($params['taxonomy_id']) && $params['taxonomy_id'] == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                            @foreach ($parents as $sub)
                                                @if ($item->id == $sub->parent_id)
                                                    <option value="{{ $sub->id }}"
                                                        {{ isset($params['taxonomy_id']) && $params['taxonomy_id'] == $sub->id ? 'selected' : '' }}>
                                                        - -
                                                        {{ $sub->name }}
                                                    </option>
                                                    @foreach ($parents as $sub_child)
                                                        @if ($sub->id == $sub_child->parent_id)
                                                            <option value="{{ $sub_child->id }}"
                                                                {{ isset($params['taxonomy_id']) && $params['taxonomy_id'] == $sub_child->id ? 'selected' : '' }}>
                                                                - - - -
                                                                {{ $sub_child->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Status')</label>
                                <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($postStatus as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ isset($params['status']) && $key == $params['status'] ? 'selected' : '' }}>
                                            {{ __($value) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Is featured')</label>
                                <select name="is_featured" id="is_featured" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="">@lang('Please select')</option>
                                    @foreach ($booleans as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ isset($params['is_featured']) && $key == $params['is_featured'] ? 'selected' : '' }}>
                                            @lang($value)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>@lang('Filter')</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-sm mr-10">@lang('Submit')</button>
                                    <a class="btn btn-default btn-sm" href="{{ route(Request::segment(2) . '.index') }}">
                                        @lang('Reset')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        {{-- End search form --}}

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">@lang('List')</h3>
                @isset($languages)
                    @foreach ($languages as $item)
                        @if ($item->is_default == 1 && $item->lang_locale != Request::get('lang'))
                            @if (Request::get('lang') != '')
                                <a class="text-primary pull-right"
                                    href="{{ route(Request::segment(2) . '.index') }}" style="padding-left: 15px">
                                    <i class="fa fa-language"></i> {{ __($item->lang_name) }}
                                </a>
                            @endif
                        @else
                            @if (Request::get('lang') != $item->lang_locale)
                                <a class="text-primary pull-right"
                                    href="{{ route(Request::segment(2) . '.index') }}?lang={{ $item->lang_locale }}"
                                    style="padding-left: 15px">
                                    <i class="fa fa-language"></i> {{ __($item->lang_name) }}
                                </a>
                            @endif
                        @endif
                    @endforeach
                @endisset
                <span class="pull-right">@lang('Translations'): </span>
            </div>
            <div class="box-body table-responsive">
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

                @if (count($rows) == 0)
                    <div class="alert alert-warning alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        @lang('not_found')
                    </div>
                @else
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Image')</th>
                                <th style="width: 25%">@lang('Url Mapping')</th>
                                <th>@lang('Post category')</th>
                                <th>@lang('Is featured')</th>
                                <th>@lang('Order')</th>
                                <th>@lang('Updated at')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($rows as $row)
                                @if ($row->parent_id == 0 || $row->parent_id == null)
                                    <form action="{{ route(Request::segment(2) . '.destroy', $row->id) }}" method="POST"
                                        onsubmit="return confirm('@lang('confirm_action')')">
                                        <tr class="valign-middle">
                                            <td>
                                                <strong
                                                    style="font-size: 14px;">{{ $row->json_params->name->{$lang} ?? $row->name }}</strong>
                                            </td>
                                            @php
                                                $url_mapping = route('frontend.page', ['taxonomy' => $row->alias ?? '']);
                                            @endphp
                                            <td>
                                                <img width="100px"
                                                    src="{{ $row->image ?? url('themes/admin/img/no_image.jpg') }}"
                                                    alt="{{ $row->name }}">
                                            </td>
                                            <td>
                                                <a href="{{ $url_mapping }}" target="_blank"
                                                    rel="noopener noreferrer">{{ $url_mapping }}</a>
                                                <a target="_new" href="{{ $url_mapping }}" data-toggle="tooltip"
                                                    title="@lang('Link')" data-original-title="@lang('Link')">
                                                    <span class="btn btn-flat btn-xs btn-info">
                                                        <i class="fa fa-external-link"></i>
                                                    </span>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $row->taxonomy_title }}
                                            </td>
                                            <td class="wrap-load-hot" data-token="{{ csrf_token() }}" data-url="{{ route('admin.updateIsfeatured',['table'=>'cms_posts', 'id'=>$row->id]) }}">
                                                @include('admin.components.load-change-is_featured',['data'=>$row,'type'=>'bản ghi'])
                                            </td>
                                            <td>
                                                <input data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadOrderVeryModel',['table'=>'cms_posts','id'=>$row->id]) }} " class="lb-order text-center"  type="number" min="0" value="{{ $row->iorder?$row->iorder:0 }}" style="width:50px" />
                                            </td>
                                            <td>
                                                {{ $row->updated_at }}
                                            </td>
                                            <td class="wrap-load-active" data-token="{{ csrf_token() }}" data-url="{{ route('admin.loadStatusPost',['id'=>$row->id]) }}">
                                                @include('admin.components.load-change-status',['data'=>$row,'type'=>'bản ghi'])
                                            </td>
                                            
                                            <td>
                                                <a class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                    title="@lang('Edit')" data-original-title="@lang('Edit')"
                                                    href="{{ route(Request::segment(2) . '.edit', $row->id) }}">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit"
                                                    data-toggle="tooltip" title="@lang('Delete')"
                                                    data-original-title="@lang('Delete')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <div class="box-footer clearfix">
                <div class="row">
                    <div class="col-sm-5">
                        Tìm thấy {{ $rows->total() }} kết quả
                    </div>
                    <div class="col-sm-7">
                        {{ $rows->withQueryString()->links('admin.pagination.default') }}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
