@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
        return $item->parent_id == $block->id;
    });
  @endphp

  <section class="section section-padding top-border p-t-20 m-b-20">
    <div class="section-container">
      <div class="block block-image slider">
        <div class="block-widget-wrap">
          <div class="slick-wrap">
            <div class="slick-sliders" data-nav="0" data-columns4="2" data-columns3="3" data-columns2="4" data-columns1="4" data-columns1440="5" data-columns="5">
              @if ($block_childs)
                @foreach ($block_childs as $item)
                  @php
                    $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                    $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                    $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                    $image = $item->image != '' ? $item->image : null;
                    $image_background = $item->image_background != '' ? $item->image_background : null;
                    $url_link = $item->url_link != '' ? $item->url_link : '';
                    $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                    $icon = $item->icon != '' ? $item->icon : '';
                  @endphp

                  <div class="item slick-slide">
                    <div class="item-image">
                      <a href="#"> 
                        <img width="450" height="450" src="{{ $image }}" alt="{{ $title_childs }}">
                      </a>
                    </div>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
