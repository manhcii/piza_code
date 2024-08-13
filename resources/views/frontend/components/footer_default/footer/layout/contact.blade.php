@if ($component)
    @php
        $title = $component->json_params->title->{$locale} ?? $component->title;
        $brief = $component->json_params->brief->{$locale} ?? $component->brief;
        $image = $component->image != '' ? $component->image : null;
        // Filter all blocks by parent_id
        $component_childs = $all_components->filter(function ($item, $key) use ($component) {
            return $item->parent_id == $component->id;
        });
    @endphp
    <div class="footer-image">
        <img src="{{$image}}" alt="{{$title}}" title="{{$title}}" />
    </div>
@endif
