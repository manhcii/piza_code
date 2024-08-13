@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
        return $item->parent_id == $block->id;
    });
  @endphp

  <section class="section section-padding top-border p-t-70 m-b-70">
    <div class="section-container">
      <div class="block block-testimonial layout-2">
        <div class="block-widget-wrap">
          <div class="block-title"><h2>{{ $brief }}</h2></div>
          <div class="block-content">
            <div class="testimonial-wrap slick-wrap">
              <div class="slick-sliders" data-slidestoscroll="true" data-nav="1" data-dots="0" data-columns4="1" data-columns3="1" data-columns2="2" data-columns1="2" data-columns="3">
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

                    <div class="testimonial-content">
                      <div class="item">
                        <div class="testimonial-item">
                          <div class="testimonial-icon">
                            <div class="rating">
                              <div class="star star-5"></div>
                            </div>
                            <span class="icon-quote"></span>
                          </div>
                          <h2 class="testimonial-title">{{ $brief_childs }}</h2>
                          <div class="testimonial-excerpt">
                            {{ $content_childs }}
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
    </div>
  </section>
@endif
