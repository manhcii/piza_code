@if ($component)
    @php
        $title = $component->json_params->title->{$locale} ?? $component->title;
        $brief = $component->json_params->brief->{$locale} ?? $component->brief;
        $image = $component->image != '' ? $component->image : null;
        // Filter all blocks by parent_id
        $component_childs = $all_components->filter(function ($item, $key) use ($component) {
            return $item->parent_id == $component->id;
        });
        dd($locale);
        $component_childs = $all_components->filter(function ($item, $key) use ($component) {
            return $item->parent_id == $component->id;
        });
    @endphp
    <div class="languages-wrapper">
        <div class="languages-image">
            <img src="{{$image }}" alt="{{$title}}" />
        </div>
        <select id="languages">
            <option value="UK" selected>United Kingdom</option>
            <option value="VN">Viet Nam</option>
            <option value="US">United State</option>
            <option value="CN">China</option>
            <option value="JP">Japan</option>
        </select>
    </div>
@endif
