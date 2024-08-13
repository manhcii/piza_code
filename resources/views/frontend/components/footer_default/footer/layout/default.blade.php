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
    <div class="footer-link">
        <h3 class="title">{{ $title }}</h3>
        <ul class="footer-link-list">
            @if ($component_childs)
                @foreach ($component_childs as $item)
                    @php
                        $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                        $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                        $image_childs = $item->image != '' ? $item->image : null;
                        $url_link = $item->url_link != '' ? $item->url_link : '';
                        $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                    @endphp
                    <li class="footer-link-item">
                        <a href="{{ $url_link }}" title="{{ $title_childs }}" class="text">{{ $title_childs }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
@endif
