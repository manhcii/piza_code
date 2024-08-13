@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $image_background = $block->image_background != '' ? $block->image_background : '';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $icon = $block->icon ?? '';
        $gallery_image = $block->json_params->gallery_image ?? [];
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });

    @endphp
    <section id="fhm-about-memorable">
        <div class="container">
            <div class="heading-block-m">
                <span class="badge"> {{ $brief }} </span>
                <h2 class="title">
                    {!! $title !!}
                </h2>
            </div>
            <div class="memorable-wrapper">
                <div class="memorable-years">
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
                                        $url_link_childs = $item->url_link != '' ? $item->url_link : '';
                                        $url_link_childs_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                                        $icon_childs = $item->icon ?? '';
                                        $gallery_image_childs = $item->json_params->gallery_image ?? '';
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="year">
                                            <h3 class="number">{{ $title_childs }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="memorable-slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @if ($block_childs)
                                @foreach ($block_childs as $items)
                                    @php
                                        $title_childs = $items->json_params->title->{$locale} ?? $items->title;
                                        $brief_childs = $items->json_params->brief->{$locale} ?? $items->brief;
                                        $content_childs = $items->json_params->content->{$locale} ?? $items->content;
                                        $image_childs = $items->image != '' ? $items->image : null;
                                        $image_background_childs = $items->image_background != '' ? $items->image_background : null;
                                        $url_link_childs = $items->url_link != '' ? $items->url_link : '';
                                        $url_link_childs_title = $items->json_params->url_link_title->{$locale} ?? $items->url_link_title;
                                        $icon_childs = $items->icon ?? '';
                                        $gallery_image_childs = $items->json_params->gallery_image ?? '';
                                        $block_item_childs = $blocks->filter(function ($item, $key) use ($items) {
                                            return $item->parent_id == $items->id;
                                        });
                                    @endphp
                                    <div class="swiper-slide">
                                        <ul class="memorable-content">
                                            @if ($block_childs)
                                                @foreach ($block_item_childs as $item)
                                                    @php
                                                        $title_items_childs = $item->json_params->title->{$locale} ?? $item->title;
                                                        $brief_items_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                                                        $content_items_childs = $item->json_params->content->{$locale} ?? $item->content;
                                                    @endphp
                                                    <li class="memorable-content-item">
                                                        <h4 class="date">{{ $title_items_childs }}</h4>
                                                        <p class="text">
                                                            {{ $brief_items_childs }}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="slider-button-next slider-button-next-m">
                        <svg width="12" height="17" viewBox="0 0 12 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.69231 1.23077L10 9.53847L1.69231 16.1846" stroke="#CF3031" stroke-width="2" />
                        </svg>
                    </div>
                    <div class="slider-button-prev slider-button-prev-m">
                        <svg width="12" height="17" viewBox="0 0 12 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.3077 1.23077L2 9.53847L10.3077 16.1846" stroke="#CF3031" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
