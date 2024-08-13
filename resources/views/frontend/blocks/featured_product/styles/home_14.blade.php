@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    $content = $block->json_params->content->{$locale} ?? $block->content;
    $url_link = $block->url_link ?? '';
    $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
    $image = $block->image ?? '';
    $image_background = $block->image_background ?? '';

    // Filter all blocks by parent_id
    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
        return $item->parent_id == $block->id;
    });
    $index = 1;
  @endphp

  <section class="section section-padding m-b-70">
    <div class="section-container">
      <div class="row sm-m-0">
        <div class="col-md-6 sm-m-b-50 sm-p-0">
          <div class="block block-image text-center position-relative">
            <img width="671" height="503" src="{{ $image_background }}" alt="{!! $brief !!}">
            <img class="animation-round position-v-top position-h-center" width="106" height="105" src="{{ $image }}" alt="{!! $brief !!}">
          </div>
        </div>
        <div class="col-md-6 sm-p-0">
          <div class="block block-lookbook layout-3 position-v-center">
            <div class="lookbook-intro-wrap m-l-0">
              <div class="lookbook-intro">
                <h2 class="title">{!! $brief !!}</h2>
                <div class="description">{{ $content }}</div>			
                <a href="{{ $url_link }}" class="button button-black">{{ $url_link_title }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
