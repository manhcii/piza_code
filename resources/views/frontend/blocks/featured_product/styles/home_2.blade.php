@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    $content = $block->json_params->content->{$locale} ?? $block->content;
    $image = $block->image != '' ? $block->image : null;
    $image_background = $block->image_background != '' ? $block->image_background : null;
    $video = $block->json_params->video ?? null;
    $video_background = $block->json_params->video_background ?? null;
    $url_link = $block->url_link != '' ? $block->url_link : '';
    $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
        return $item->parent_id == $block->id;
    });
  @endphp

  <section class="section section-padding m-b-70">
    <div class="section-container large">
      <div class="block-widget-wrap">
        <!-- Block Lookbook -->
        <div class="block block-lookbook no-space">
          <div class="background-overlay"></div>
          <div class="row">
            <div class="col-md-6">
              <div class="lookbook-wrap default"> 
                <div class="lookbook-container">
                  <div class="lookbook-content">
                    <div class="item">
                      <img width="869" height="702" src="{{ $image }}" alt="{{ $title }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="lookbook-intro-wrap position-center text-center">
                <div class="lookbook-intro">
                  <h4 class="sub-title">{{ $content }}</h4>
                  <h2 class="title">{!! $brief !!}</h2>
                  <a href="{{ $url_link }}" class="button button-white">{{ $url_link_title }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
