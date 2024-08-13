@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
        return $item->parent_id == $block->id;
    });
  @endphp

  <section class="section section-padding m-b-70">
    <div class="section-container large">
      <div class="block block-testimonial layout-1">
        <div class="block-widget-wrap">
          <div class="testimonial-wrap slick-wrap">
            <div class="slick-sliders" data-slidestoscroll="true" data-nav="1" data-dots="0" data-columns4="1" data-columns3="1" data-columns2="1" data-columns1="1" data-columns="1">
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
                  @endphp

                  <div class="testimonial-content">
                    <div class="item">
                      <div class="testimonial-item">
                        <div class="rating">
                          <div class="star star-5"></div>
                        </div>
                        <div class="testimonial-excerpt">
                          {{ $brief_childs }}
                        </div>								
                      </div>
                      <div class="testimonial-image image-position-top">
                        <div class="thumbnail">
                          <img width="62" height="62" src="{{ $image }}" alt="{{ $title_childs }}">							
                        </div>
                        <div class="testimonial-info">
                          <h2 class="testimonial-customer-name">{{ $title_childs }}</h2>
                        </div>
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
