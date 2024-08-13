
@isset($component)
<div class="block block-product-filter">
    <div class="block-title">
        <h2>{{$component->titel}}</h2>
    </div>
    <div class="block-content">
        <div id="slider-range" class="price-filter-wrap">
            <div class="filter-item price-filter d-flex">
                <div class="layout-slider">
                    <input id="price-filter" name="price" value="{{$request['price']??'0;1000'}}" />
                </div>
                <div class="layout-slider-settings ml-4">
                    <button type="submit" class="btn btn-success">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endisset
