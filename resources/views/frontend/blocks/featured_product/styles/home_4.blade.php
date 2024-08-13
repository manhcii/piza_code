@if ($block)
  @php
    $title = $block->json_params->title->{$locale} ?? $block->title;
    $brief = $block->json_params->brief->{$locale} ?? $block->brief;
    $content = $block->json_params->content->{$locale} ?? $block->content;
    $image = $block->image != '' ? $block->image : null;

    $block_childs = $blocks->filter(function ($item, $key) use ($block) {
      return $item->parent_id == $block->id;
    });
    $first_child = $block_childs->first();
    $last_child = $block_childs->last();
  @endphp

  <section class="section section-padding m-b-80">
    <div class="section-container">
      <div class="block block-lookbook layout-2">
        <div class="block-widget-wrap">
          <div class="row">
            @php
              $title_childs = $first_child->json_params->title->{$locale} ?? $first_child->title;
              $brief_childs = $first_child->json_params->brief->{$locale} ?? $first_child->brief;
              $content_childs = $first_child->json_params->content->{$locale} ?? $first_child->content;
              $image = $first_child->image != '' ? $first_child->image : null;
              $image_background = $first_child->image_background != '' ? $first_child->image_background : null;
              $url_link = $first_child->url_link != '' ? $first_child->url_link : '';
              $url_link_title = $first_child->json_params->url_link_title->{$locale} ?? $first_child->url_link_title;
              $alias = $first_child->alias ?? '';
            @endphp
            <div class="col-md-6">
              <div class="lookbook-wrap default"> 
                <div class="lookbook-container">
                  <div class="lookbook-content">
                    <div class="item">
                      <img width="598" height="594" src="{{ $image_background }}" alt="{{ $title_childs }}">
                      <div class="item-lookbook" style="height:30px; width:30px; left:45.99%; top:48.82%">
                        <span class="number-lookbook">1</span>
                        <div class="content-lookbook" style="left:33px; top:10px;">
                          <div class="item-thumb">
                            <a href="{{ $url_link }}">
                              <img width="1000" height="1000" src="{{ $image }}" alt="{{ $title_childs }}">
                            </a>
                          </div>
                          <div class="content-lookbook-bottom">
                            <div class="item-title">
                              <a href="{{ $url_link }}">{{ $title_childs }}</a>
                            </div>
                            <span class="price">
                              <del aria-hidden="true"><span>{{ $brief_childs }}</span></del> 
                              <ins><span>{{ $content_childs }}</span></ins>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @php
              $title_childs_2 = $last_child->json_params->title->{$locale} ?? $last_child->title;
              $brief_childs_2 = $last_child->json_params->brief->{$locale} ?? $last_child->brief;
              $content_childs_2 = $last_child->json_params->content->{$locale} ?? $last_child->content;
              $image_2 = $last_child->image != '' ? $last_child->image : null;
              $image_background_2 = $last_child->image_background != '' ? $last_child->image_background : null;
              $url_link_2 = $last_child->url_link != '' ? $last_child->url_link : '';
              $url_link_title_2 = $last_child->json_params->url_link_title->{$locale} ?? $last_child->url_link_title;
              $alias_2 = $last_child->alias ?? '';
            @endphp
            <div class="col-md-6">
              <div class="lookbook-wrap default right"> 
                <div class="lookbook-container">
                  <div class="lookbook-intro-wrap position-center text-center">
                    <div class="lookbook-intro">
                      <h2 class="title">{{ $brief }}</h2>
                      <h4 class="sub-title">{{ $content }}</h4>
                      <a href="{{ $url_link_2 }}" class="button btn-underline center">{{ $url_link_title_2 }}</a>
                    </div>
                  </div>
                  <div class="lookbook-content">
                    <div class="item">
                      <img width="599" height="671" src="{{ $image_background_2 }}" alt="{{ $title_childs_2 }}">
                      <div class="item-lookbook" style="height:30px; width:30px; left:16.19%; top:35.77%">
                        <span class="number-lookbook">1</span>
                        <div class="content-lookbook" style="left:33px; top:10px;">
                          <div class="item-thumb">
                            <a href="{{ $url_link_2 }}">
                              <img width="1000" height="1000" src="{{ $image_2 }}" alt="">
                            </a>
                          </div>
                          <div class="content-lookbook-bottom">
                            <div class="item-title">
                              <a href="{{ $url_link_2 }}">{{ $title_childs_2 }}</a>
                            </div>
                            <span class="price">
                              <del aria-hidden="true"><span>{{ $brief_childs_2 }}</span></del> 
                              <ins><span>{{ $content_childs_2 }}</span></ins>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
