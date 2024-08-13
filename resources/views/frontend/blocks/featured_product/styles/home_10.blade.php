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
  @endphp

  <section class="section m-b-70">
    <div class="block block-lookbook layout-3 no-space">
      <div class="background-overlay"></div>
      <div class="row">
        <div class="col-lg-6">
          <div class="lookbook-intro-wrap">
            <div class="lookbook-intro">
              <h2 class="title">{!! $brief !!}</h2>
              <div class="description">{!! $content !!}</div>			
              <a href="{{ $url_link }}" class="button button-black">{{ $url_link_title }}</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="lookbook-wrap default"> 
            <div class="lookbook-container">
              <div class="lookbook-content">
                <div class="item">
                  <img width="961" height="668" src="{{ $image }}" alt="{!! $brief !!}">
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
                      @endphp

                      @if ($item->json_params->style == 'left')
                        <div class="item-lookbook" style="height:30px;width:30px;left:43.91%;top:72.01%">
                          <span class="number-lookbook">1</span>
                          <div class="content-lookbook" style="left:33px;bottom:10px;">
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
                                  <del aria-hidden="true"><span>{{ $brief_childs }}</span></del>
                                @endif
                                <ins><span>{{ $content_childs }}</span></ins>
                              </span>
                            </div>
                          </div>
                        </div>
                      @endif
                      @if ($item->json_params->style == 'right')
                        <div class="item-lookbook" style="height:30px;width:30px;left:68.68%;top:29.34%">
                          <span class="number-lookbook">2</span>
                          <div class="content-lookbook" style="left:33px;bottom:10px;">
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
                                  <del aria-hidden="true"><span>{{ $brief_childs }}</span></del>
                                @endif
                                <ins><span>{{ $content_childs }}</span></ins>
                              </span>
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
        </div>
      </div>
    </div>
  </section>
@endif
