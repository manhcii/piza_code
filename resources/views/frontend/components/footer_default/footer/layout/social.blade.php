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
         <div class="footer-col">
            <h4 class="footer-title">{{ $title }}</h4>
            <div class="footer-content">
              <ul>
                @if ($component_childs)
                @foreach ($component_childs as $item)
                    @php
                        $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                        $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                        $image_childs = $item->image != '' ? $item->image : null;
                        $url_link = $item->json_params->url_link != '' ? $item->url_link : '';
                        $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                    @endphp
              <li class="footer-link"><a href="{{ $url_link }}" title="{{ $title_childs }}">{{ $title_childs }}</a></li>
              @endforeach
              @endif
              </ul>
            </div>
          </div>
@endif
