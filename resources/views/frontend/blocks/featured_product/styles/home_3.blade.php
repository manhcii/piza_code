@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    $content = $block->json_params->content->{$locale} ?? $block->content;
    $image = $block->image != '' ? $block->image : null;
    $url_link = $block->url_link != '' ? $block->url_link : '';
    $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
      return $item->parent_id == $block->id;
    });
  @endphp

  <section class="section section-padding m-b-70">
    <div class="section-container">
      <div class="block block-product-cats layout-2">
        <div class="block-widget-wrap">
          <div class="block-title"><h2>{{ $brief }}</h2></div>
          <div class="block-content">
            <div class="row">
              @if ($block_childs)
                @foreach ($block_childs as $item)
                  @php
                    $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                    $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                    $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                    $image = $item->image != '' ? $item->image : null;
                    $image_background = $item->image_background != '' ? $item->image_background : null;
                    $video = $item->json_params->video ?? null;
                    $video_background = $item->json_params->video_background ?? null;
                    $url_link = $item->url_link != '' ? $item->url_link : '';
                    $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                    $icon = $item->icon != '' ? $item->icon : '';
                    $style = isset($item->json_params->style) && $item->json_params->style == 'slider-caption-right' ? 'd-none' : '';
                    $image_for_screen = null;
                    $alias = $item->alias ?? '';
                  @endphp

                  <div class="col-md-3 sm-m-b-30">
                    <div class="cat-item">
                      <div class="cat-image">
                        <a href="{{ $url_link }}">
                          <img width="303" height="366" src="{{ $image }}" alt="{{ $title_childs }}">
                        </a>
                      </div>
                      <div class="cat-title">
                        <a href="{{ $url_link }}">
                          <h3>{{ $title_childs }}</h3>
                        </a>
                      </div>
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
