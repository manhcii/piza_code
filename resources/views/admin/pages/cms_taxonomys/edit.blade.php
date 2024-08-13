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
            <div class="row">
                <div class="col-lg-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('Update form')</h3>
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('Taxonomy') <small class="text-red">*</small></label>
                                                    <select name="taxonomy" id="taxonomy" class="form-control select2"
                                                        required>
                                                        <option value="">@lang('Please select')</option>
                                                        @foreach (App\Consts::TAXONOMY as $key => $value)
                                                            <option value="{{ $key }}"
                                                                {{ $key == $detail->taxonomy ? 'selected' : '' }}>
                                                                {{ __($value) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('Title') <small class="text-red">*</small></label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="@lang('Title')" value="{{ $detail->name }}"
                                                        required>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('Parent element')</label>
                                                    <select name="parent_id" id="parent_id" class="form-control select2">
                                                        <option value="">== @lang('ROOT') ==</option>
                                                        @foreach ($categorys as $item)
                                                            @if (($item->parent_id == 0 || $item->parent_id == null) && $item->taxonomy == $detail->taxonomy)
                                                                <option value="{{ $item->id }}"
                                                                    {{ $detail->parent_id == $item->id ? 'selected' : '' }}>
                                                                    {{ $item->name }}</option>

                                                                @foreach ($categorys as $sub)
                                                                    @if ($item->id == $sub->parent_id)
                                                                        <option value="{{ $sub->id }}"
                                                                            {{ $detail->parent_id == $sub->id ? 'selected' : '' }}>
                                                                            - - {{ $sub->name }}
                                                                        </option>

                                                                        @foreach ($categorys as $sub_child)
                                                                            @if ($sub->id == $sub_child->parent_id)
                                                                                <option value="{{ $sub_child->id }}"
                                                                                    {{ $detail->parent_id == $sub_child->id ? 'selected' : '' }}>
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
                                                <div class="form-group">
                                                    <label>URL tùy chọn</label>
                                                    <i class="fa fa-coffee text-red" aria-hidden="true"></i>
                                                    <small class="form-text">
                                                        (
                                                        <i class="fa fa-info-circle"></i>
                                                        Maximum 100 characters in the group: "A-Z", "a-z", "0-9" and "-_" )
                                                    </small>
                                                    <input name="alias" class="form-control"
                                                        value="{{ $detail->alias ?? old('alias') }}" />
                                                </div>


                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('Description')</label>
                                                    <textarea name="json_params[brief][vi]" class="form-control" rows="5">{{ $detail->json_params->brief->vi ?? old('json_params[brief][vi]') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>@lang('Content')</label>
                                                        <textarea name="json_params[content][vi]" class="form-control" id="content_vi">{{ $detail->json_params->content->vi ?? old('json_params[content][vi]') }}</textarea>
                                                    </div>
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
                <div class="col-lg-12">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Route Name')</label>
                                        <small class="text-red">*</small>
                                        <select name="json_params[route_name]" id="route_name" class="form-control select2"
                                            style="width:100%" required autocomplete="off">
                                            <option value="">@lang('Please select')</option>
                                            @foreach ($route_name as $key => $item)
                                                <option value="{{ $item['name'] }}"
                                                    {{ isset($detail->json_params->route_name) && $detail->json_params->route_name == $item['name'] ? 'selected' : '' }}>
                                                    {{ __($item['title']) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $route = $detail->json_params->route_name ?? '';
                                    $templates = collect(App\Consts::ROUTE_NAME);
                                    $template = $templates->first(function ($item, $key) use ($route) {
                                        return $item['name'] == $route;
                                    });
                                @endphp
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Template')</label>
                                        <small class="text-red">*</small>
                                        <select name="json_params[template]" id="template" class="form-control select2"
                                            style="width:100%" required autocomplete="off">
                                            <option value="">@lang('Please select')</option>
                                            @isset($template['template'])
                                                @foreach ($template['template'] as $key => $item)
                                                    <option value="{{ $item['name'] }}"
                                                        {{ isset($detail->json_params->template) && $detail->json_params->template == $item['name'] ? 'selected' : '' }}>
                                                        {{ __($item['title']) }}
                                                    </option>
                                                @endforeach
                                            @endisset

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h3>
                                        @lang('Setting Widgets')
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-15">
                                        @lang('Selected Widgets')
                                    </h4>
                                    <div class="dd checkbox_list" id="widget_selected">
                                        @if (isset($detail->json_params->widget) && count($detail->json_params->widget) > 0)
                                            <ol class=" dd-list">
                                                @foreach ($widgets as $item)
                                                    @if (in_array($item->id, $detail->json_params->widget ?? []))
                                                        <li class="dd-item" data-id="{{ $item->id }}">
                                                            <div class="dd-handle">
                                                                <strong>{{ __($item->title) . ' (' . $item->widget_name . ')' }}</strong>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-15">
                                        @lang('Available Widgets')
                                    </h4>
                                    <div class="dd checkbox_list" id="widget_available">
                                        @if (count($widgets) > 0)
                                            <ol class=" dd-list">
                                                @foreach ($widgets as $item)
                                                    @if (!in_array($item->id, $detail->json_params->widget ?? []))
                                                        <li class="dd-item" data-id="{{ $item->id }}">
                                                            <div class="dd-handle ">
                                                                <strong>{{ __($item->title) . ' (' . $item->widget_name . ')' }}</strong>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" id="widgets_selected" name="widgets_selected" value="">

                            </div>
                        </div>


                    </div>
                </div>
        </form>
    </section>
@endsection

@section('script')
    <script>
        CKEDITOR.replace('content_vi', ck_options);

        function check_nestb() {
            $('#widgets_selected').val(JSON.stringify($('#widget_selected').nestable('serialize')));
            return true;
        }
        var no_image_link = '{{ url('themes/admin/img/no_image.jpg') }}';
        $('.list_image').on('change', function() {
            var img_path = $(this).val();
            $(this).parents('.box_image').addClass('active');
            $(this).parents('.box_image').find('img').attr('src', img_path);
        });
        $('.img-width, .btn-remove').on('mouseover', function(e) {
            $(this).parents('.active').find('.btn-remove').show();
        });
        $('.img-width, .btn-remove').on('mouseout', function(e) {
            $(this).parents('.active').find('.btn-remove').hide();
        });
        $('.box_image').on('click', '.btn-remove', function() {
            $(this).hide();
            let par = $(this).parents('.box_image');
            par.removeClass('active');
            par.find('img').attr('src', no_image_link);
            par.find('.list_image').val('');
        });

        $(document).ready(function() {
            $('#widget_selected, #widget_available').nestable({
                group: 1,
                maxDepth: 1,
            });
            var taxonomys = @json($taxonomys ?? null);

            // Change to filter type by name taxonomy
            $(document).on('change', '#taxonomy', function() {
                let _value = $(this).val();
                let _html = $('#parent_id');
                let _list = taxonomys.filter(function(e, i) {
                    return ((e.parent_id == 0 || e.parent_id == null) && e.taxonomy == _value);
                });
                let _content = '<option value="">== @lang('ROOT') ==</option>';
                if (_list) {
                    _list.forEach(element => {
                        _content += '<option value="' + element.id + '"> ' + element.title +
                            ' </option>';
                        let _child = taxonomys.filter(function(e, i) {
                            return ((e.parent_id == element.id) && e.taxonomy == _value);
                        });
                        if (_child) {
                            _child.forEach(element => {
                                _content += '<option value="' + element.id + '">- - ' +
                                    element.title + ' </option>';
                            });
                        }
                    });
                    _html.html(_content);

                    $('#parent_id').select2();
                }
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
