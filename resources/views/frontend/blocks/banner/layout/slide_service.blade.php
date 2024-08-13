@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : null;
        $image_background = $block->image_background != '' ? $block->image_background : null;
        $url_link = $block->url_link ?? null;
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id && $item->json_params->style != 'decor';
        });
        $block_first = $blocks->first(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id && $item->json_params->style != 'decor';
        });
        $block_childs_decor = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id && $item->json_params->style == 'decor';
        });
    @endphp

    <section class="services-block-2">
        <div class="container">
            <div class="services-block-wrapper">
                <div class="services-block-slider-container">
                    <div class="services-block-image"
                        style=" background-image: url({{$block_first->image??''}}); ">
                        @if ($block_childs_decor)
                            @foreach ($block_childs_decor as $item)
                                @php
                                    $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                                    $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                                    $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                                    $image_childs = $item->image != '' ? $item->image : null;
                                    $image_background = $item->image_background != '' ? $item->image_background : null;
                                @endphp

                                <div class="decor-element">
                                    <img src="{{ $image_childs }}" alt="{{ $title_childs }}" title="{{ $title_childs }}" />
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="services-block-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @if ($block_childs)
                                    @foreach ($block_childs as $item)
                                        @php
                                            $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                                            $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                                            $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                                            $image_childs = $item->image != '' ? $item->image : null;
                                            $image_background_childs = $item->image_background != '' ? $item->image_background : null;
                                        @endphp
                                        <div class="swiper-slide">
                                            <div class="services-slider-item">
                                                <img src="{{ $image_childs }}" alt="{{ $title_childs }}"
                                                    title="{{ $title_childs }}" />
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="slider-button-next slider-button-next-s">
                            <svg width="16" height="11" viewBox="0 0 16 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.4614 1.61538L7.07681 9L1.16912 1.61538" stroke="#CF3031"
                                    stroke-width="2" />
                            </svg>
                        </div>
                        <div class="slider-button-prev slider-button-prev-s">
                            <svg width="16" height="11" viewBox="0 0 16 11" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.4614 9.38462L7.07681 2L1.16912 9.38462" stroke="#CF3031"
                                    stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="services-block-content">
                    <div class="heading-block-s">
                        <h3 class="title">
                            {{$title}}
                        </h3>
                        <p class="desc">
                            {{$brief}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
