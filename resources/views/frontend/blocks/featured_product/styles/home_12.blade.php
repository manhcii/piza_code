@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    $content = $block->json_params->content->{$locale} ?? $block->content;
    $url_link = $block->url_link ?? '';
    $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
    $image = $block->image ?? '';

    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
        return $item->parent_id == $block->id;
    });
    $index = 1;
  @endphp

  <section class="section top-border p-t-70 m-b-70">
    <div class="block block-banners banners-effect">
      <div class="block-title title-big"><h2>{{ $brief }}</h2></div>
      <div class="block-content">
        <div class="block-widget-banner layout-14 no-space">
          <div class="banners">
            @if ($block_childs)
              @foreach ($block_childs as $item)
                @php
                  $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                  $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                  $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                  $image_childs = $item->image != '' ? $item->image : null;
                  $image_background = $item->image_background != '' ? $item->image_background : null;
                  $url_link = $item->url_link != '' ? $item->url_link : '';
                  $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                  $icon = $item->icon != '' ? $item->icon : '';
                  $index++
                @endphp
                @if ($index % 2 == 0)
                  <div class="row">
                    <div class="col-md-6">
                      <div class="banner-image">
                        <a href="{{ $url_link }}">
                          <img width="961" height="590" src="{{ $image_childs }}" alt="{{ $title_childs }}">
                        </a>
                      </div>
                    </div>
                    <div class="col-md-6 banner-infor">
                      <div class="banner-wrapper-infor">
                        <div class="info">
                          <div class="content">
                            <a class="link-title" href="{{ $url_link }}">
                              <h3 class="title-banner">{{ $title_childs }}</h3>
                            </a>
                            <div class="banner-image-description">
                              {{ $brief_childs }}
                            </div>
                            <a class="button btn-underline" href="{{ $url_link }}">{{ $url_link_title }}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @else
                  <div class="row">
                    <div class="col-md-6 banner-infor">
                      <div class="banner-wrapper-infor">
                        <div class="info">
                          <div class="content">
                            <a class="link-title" href="{{ $url_link }}">
                              <h3 class="title-banner">{{ $title_childs }}</h3>
                            </a>
                            <div class="banner-image-description">
                              {{ $brief_childs }}
                            </div>
                            <a class="button btn-underline" href="{{ $url_link }}">{{ $url_link_title }}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="banner-image">
                        <a href="{{ $url_link }}">
                          <img width="961" height="590" src="{{ $image_childs }}" alt="{{ $title_childs }}">
                        </a>
                      </div>
                    </div>
                  </div>
                @endif
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
