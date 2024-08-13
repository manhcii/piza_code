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

  <section class="section m-b-70">
    <div class="block block-lookbook">
      <div class="lookbook-wrap default"> 
        <div class="lookbook-container">
          <div class="lookbook-content">
            <div class="item">
              <img width="1920" height="809" src="{{ $image }}" alt="{{ $title }}">
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

                    <div class="item-lookbook" style="height:30px;width:30px;{{ $icon }}">
                      <span class="number-lookbook">1</span>
                      <div class="content-lookbook" style="left:33px;top:10px;">
                        <div class="item-thumb">
                          <a href="{{ $url_link }}">
                            <img width="1000" height="1000" src="{{ $image_childs }}" alt="{{ $title_childs }}">
                          </a>
                        </div>
                        <div class="content-lookbook-bottom">
                          <div class="item-title">
                            <a href="{{ $url_link }}">{{ $title_childs }}</a>
                          </div>
                          <span class="price">
                            @if ($brief_childs)
                              <del aria-hidden="true"><span>${{ $brief_childs }}</span></del> 
                            @endif
                            <ins><span>${{ $content_childs }}</span></ins>
                          </span>
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
