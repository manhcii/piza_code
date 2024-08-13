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
    <div class="section-container">
      <div class="block block-banners layout-7 banners-effect">
        <div class="block-widget-wrap">
          <div class="row">
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

                <div class="col-md-4 sm-m-b-50">
                  <div class="block-widget-banner layout-9">
                    <div class="bg-banner">
                      <div class="banner-wrapper banners">
                        <div class="banner-image">
                          <a href="{{ $url_link }}">
                            <img width="409" height="492" src="{{ $image }}" alt="{{ $title_childs }}">
                          </a>
                        </div>
                        <div class="banner-wrapper-infor">
                          <div class="info">
                            <div class="content">
                              <a class="link-title" href="{{ $url_link }}">
                                <h3 class="title-banner">{{ $title_childs }}</h3>
                              </a>
                              <div class="banner-image-description">
                                {{ $brief_childs }}
                              </div>
                            </div>
                          </div>
                        </div>
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
  </section>
@endif
