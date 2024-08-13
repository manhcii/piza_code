@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $image_background = $block->image_background != '' ? $block->image_background : '';
        $icon = $block->icon != '' ? $block->icon : '';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $gallery_image = $block->json_params->gallery_image ?? [];
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
    @endphp



    <section id="fhm-homepage-instagram">
        <div class="container">
            <div class="instagram-heading">
                <h2 class="instagram-heading-title">{{ $title }}</h2>
                <a href="{{ $url_link }}" title="{{ $url_link_title }}"
                    class="instagram-heading-button">{{ $url_link_title }}
                    <span class="icon">
                        {!! $icon !!}
                    </span></a>
            </div>
            <div class="instagram-slider">
                @if ($block_childs)
                    @foreach ($block_childs as $item)
                        @php
                            $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                            $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                            $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                            $image = $item->image != '' ? $item->image : null;
                            $image_background = $item->image_background != '' ? $item->image_background : null;
                            $url_link_childs = $item->url_link != '' ? $item->url_link : '';
                            $url_link_childs_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                            $gallery_image_childs = $item->json_params->gallery_image ?? '';
                        @endphp
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @if (count($gallery_image_childs) > 0)
                                    @foreach ($gallery_image_childs as $val_image)
                                        <div class="swiper-slide">
                                            <a href="{{$url_link_childs}}" title="instagram post">
                                                <div class="instagram-item">
                                                    <div class="instagram-item-image">
                                                        <img src="{{$val_image}}" alt="{{$title_childs}}"
                                                            title="{{$title_childs}}" />
                                                    </div>
                                                    <div class="instagram-item-overlay">
                                                        <div class="icon">
                                                            <img src="{{$image}}"
                                                                alt="{{$title_childs}}" title="{{$title_childs}}" />
                                                        </div>
                                                        <h3 class="title">{{$title_childs}}</h3>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif


                {{-- <div class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig5.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig4.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig3.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig2.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig5.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig4.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="#" title="instagram post">
                                <div class="instagram-item">
                                    <div class="instagram-item-image">
                                        <img src="./assets/images/instagram/ig3.png" alt="IG" title="IG" />
                                    </div>
                                    <div class="instagram-item-overlay">
                                        <div class="icon">
                                            <img src="./assets/images/elements/icons/Ig.svg" alt="Ig"
                                                title="Ig" />
                                        </div>
                                        <h3 class="title">Flavor.Fusion</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div> --}}
                <div class="slider-button-next slider-button-next-l">
                    <svg width="13" height="20" viewBox="0 0 13 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1L2 11L12 19" stroke="#CF3031" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>
    </section>
@endif
