@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $image_background = $block->image_background != '' ? $block->image_background : '';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $gallery_image = $block->json_params->gallery_image ?? null;
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
    @endphp
    <style>
        #fhm-homepage-testimonials {
            background-image: url('{{ $image_background }}');
            background-size: cover;
            margin-top: 100px;
            position: relative;
            background-repeat: no-repeat;
            background-position: center center;
            padding: 100px 0px;
        }
    </style>
    <section id="fhm-homepage-testimonials">
        @if (count($gallery_image) > 0)
            @foreach ($gallery_image as $val_image)
                <div class="decor-element">
                    <img src="{{ $val_image }}" alt="{{ $title }}" title="{{ $title }}" />
                </div>
            @endforeach
        @endif

        <div class="container">
            <div class="heading-block-m">
                <span class="badge">{{ $brief }}</span>
                <h2 class="title">{{ $title }}</h2>
            </div>
            <div class="testimonials-slider">
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
                                    $gallery_image_childs = $item->json_params->gallery_image ?? '';
                                    $star_child = $item->json_params->star ?? 0;
                                @endphp
                                <div class="swiper-slide">
                                    <div class="testimonials-item"
                                        style=" background-image: url({{ $image_background_childs }}); ">
                                        <div class="testimonials-content">
                                            <div class="testimonials-content-user">
                                                <img src="{{ $image_childs }}" alt="{{ $title_childs }}"
                                                    title="{{ $title_childs }}" />
                                            </div>
                                            <h3 class="testimonials-content-name">{{ $title_childs }}</h3>
                                            <p class="testimonials-content-role">{{ $brief_childs }}</p>
                                            <p class="testimonials-content-review">
                                                {{ $content_childs }}
                                            </p>
                                            <ul class="testimonials-content-rating">
                                                @for ($i = 1; $i < 6; $i++)
                                                    @php
                                                        $img_star = ($i <= $star_child) ? asset('themes/frontend/assets/images/elements/icons/star-fill.svg') : asset('themes/frontend/assets/images/elements/icons/star-no-fill.svg');
                                                    @endphp
                                                    <li class="rating-item">
                                                        <img src="{{ $img_star }}" alt="Star" title="Star" />
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="slider-button-next slider-button-next-m">
                    <svg width="13" height="20" viewBox="0 0 13 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L11 11L1 19" stroke="#CF3031" stroke-width="2" />
                    </svg>
                </div>
                <div class="slider-button-prev slider-button-prev-m">
                    <svg width="13" height="20" viewBox="0 0 13 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1L2 11L12 19" stroke="#CF3031" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
@endif
