<div class="col-lg-4">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('Publish')</h3>
        </div>
        <div class="box-body">
            <div class="btn-set">


                <button type="submit" class="btn btn-info">
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
            <h3 class="box-title">@lang('Parent element')</h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <select name="parent_id" class=" form-control select2">
                    <option value="">== @lang('ROOT') ==</option>
                    @foreach ($categorys as $val)
                        @php
                            if (isset($detail->id) && $detail->id == $val->id) {
                                continue;
                            }
                        @endphp
                        @if (empty($val->parent_id))
                            <option value="{{ $val->id }}"
                                {{ isset($detail->parent_id) && $val->id != $detail->id && $detail->parent_id == $val->id ? 'selected' : '' }}>
                                @lang($val->name)</option>
                            @foreach ($categorys as $val1)
                                @php
                                    if (isset($detail->id) && $detail->id == $val1->id) {
                                        continue;
                                    }
                                @endphp
                                @if ($val1->parent_id == $val->id)
                                    <option value="{{ $val1->id }}"
                                        {{ isset($detail->parent_id) && $val1->id != $detail->id && $detail->parent_id == $val1->id ? 'selected' : '' }}>
                                        - - @lang($val1->name)</option>
                                    @foreach ($categorys as $val2)
                                        @php
                                            if (isset($detail->id) && $detail->id == $val2->id) {
                                                continue;
                                            }
                                        @endphp
                                        @if ($val2->parent_id == $val1->id)
                                            <option value="{{ $val2->id }}"
                                                {{ isset($detail->parent_id) && $val2->id != $detail->id && $detail->parent_id == $val2->id ? 'selected' : '' }}>
                                                - - - - @lang($val2->name)</option>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </select>
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
                            {{ isset($detail->status) && $detail->status == $val ? 'checked' : '' }}>@lang($val)
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('Order')</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <input type="number" class="form-control" name="iorder" placeholder="@lang('Order')"
                    value="{{ $detail->iorder ?? old('iorder') }}">
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('Image')</h3>
        </div>
        <div class="box-body">
            <div class="form-group box_img_right {{ isset($detail->json_params->image) ? 'active' : '' }}">
                <div id="image-holder">
                    @if (isset($detail->json_params->image) && $detail->json_params->image != '')
                        <img src="{{ $detail->json_params->image }}">
                    @else
                        <img src="{{ url('themes/admin/img/no_image.jpg') }}">
                    @endif
                </div>
                <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-trash"></i></span>
                <div class="input-group">
                    <span class="input-group-btn">
                        <a data-input="image" data-preview="image-holder" class="btn btn-primary lfm"
                            data-type="cms-image">
                            <i class="fa fa-picture-o"></i> @lang('Choose')
                        </a>
                    </span>
                    <input id="image" class="form-control inp_hidden" type="hidden" name="json_params[image]"
                        placeholder="@lang('Image source')" value="{{ $detail->json_params->image ?? '' }}">
                </div>
            </div>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('Image backgroud')</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <div class="form-group box_img_right {{ isset($detail->json_params->image_thumb) ? 'active' : '' }}">
                    <div id="image_thumb-holder">
                        @if (isset($detail->json_params->image_thumb) && $detail->json_params->image_thumb != '')
                            <img src="{{ $detail->json_params->image_thumb }}">
                        @else
                            <img src="{{ url('themes/admin/img/no_image.jpg') }}">
                        @endif
                    </div>
                    <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-trash"></i></span>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a data-input="image_thumb" data-preview="image_thumb-holder"
                                class="btn btn-primary lfm" data-type="cms-image">
                                <i class="fa fa-picture-o"></i> @lang('Choose')
                            </a>
                        </span>
                        <input id="image_thumb" class="form-control inp_hidden" type="hidden"
                            name="json_params[image_thumb]" placeholder="@lang('image_link')..."
                            value="{{ $detail->json_params->image_thumb ?? '' }}">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('Page config')</h3>
        </div>
        <div class="box-body">




            <div class="form-group">
                <label>@lang('Template')</label>
                <small class="text-red">*</small>
                <select name="json_params[template]" id="template" class="form-control select2" style="width:100%"
                    required autocomplete="off">
                    <option value="" disabled>@lang('Please select')</option>
                    @isset($route_default['template'])
                        @foreach ($route_default['template'] as $key => $item)
                            <option value="{{ $item['name'] }}"
                                {{ isset($detail->json_params->template) && $detail->json_params->template == $item['name'] ? 'selected' : ($loop->index==0?'selected':'') }}>
                                @lang($item['title'])
                            </option>
                        @endforeach
                    @endisset

                </select>
            </div>

        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('Widgets config')</h3>
        </div>
        <div class="box-body">
            @foreach ($widgetConfig as $val)
                <div class="form-group">
                    <label>{{ $val->name }}</label>
                    <select name="widget[]" class=" form-control select2">
                        <option value="0">@lang('Please select')</option>
                        @foreach ($widgets as $val_wg)
                            @if ($val_wg->widget_code == $val->widget_code)
                                <option value="{{ $val_wg->id }}"
                                    {{ isset($detail->json_params->widget) && in_array($val_wg->id, $detail->json_params->widget) ? 'selected' : '' }}>
                                    @lang($val_wg->title)
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>
    </div>

</div>
