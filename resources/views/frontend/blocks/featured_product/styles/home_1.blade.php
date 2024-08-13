@if ($block)
    @php

        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $image_background = $block->image_background != '' ? $block->image_background : '';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $style = isset($block->json_params->style) && $block->json_params->style == 'slider-caption-right' ? 'd-none' : '';

        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
    @endphp

    <section class="section section-padding m-b-70">
        <div class="section-container">
            <!-- Block Banners (Layout 2) -->
            <div class="block block-banners layout-2 banners-effect">
                <div class="section-row">
                    @if ($block_childs)
                        @foreach ($block_childs as $item)
                            @if ($loop->index < 2)




                            @php
                                $title = $item->json_params->title->{$locale} ?? $item->title;
                                $brief = $item->json_params->brief->{$locale} ?? $item->brief;
                                $content = $item->json_params->content->{$locale} ?? $item->content;
                                $image = $item->image != '' ? $item->image : null;
                                $image_background = $item->image_background != '' ? $item->image_background : null;
                                $video = $item->json_params->video ?? null;
                                $video_background = $item->json_params->video_background ?? null;
                                $url_link = $item->url_link != '' ? $item->url_link : '';
                                $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                                $icon = $item->icon != '' ? $item->icon : '';
                                $style = $item->json_params->style ?? '';
                            @endphp
                            <div class="section-column {{$style=="column_left"?"left sm-m-b":"right"}}">
                                <div class="section-column-wrap">
                                    <div class="block-widget-wrap">
                                        <div class="block-widget-banner {{ ($style=="column_left")?"layout-2":"layout-3"}}">
                                            <div class="bg-banner">
                                                <div class="banner-wrapper banners">
                                                    <div class="banner-image">
                                                        <a href="{{$url_link}}">
                                                            @if ($style=="column_left")
                                                                <img width="825" height="475" src="{{$image }}"
                                                                alt="{{$title}}">
                                                            @else
                                                                <img width="571" height="475" src="{{$image }}"
                                                                alt="{{$title}}">
                                                            @endif

                                                        </a>
                                                    </div>
                                                    <div class="banner-wrapper-infor">
                                                        <div class="info">
                                                            <div class="content">
                                                                <a class="link-title" href="{{$url_link}}">
                                                                    <h3 class="title-banner">{!!$brief!!}</h3>
                                                                </a>
                                                                <div class="banner-image-description">
                                                                    {!!$content!!}
                                                                </div>
                                                                @if (!empty($url_link_title) )
                                                                    <a class="button button-outline" href="{{$url_link}}">{{$url_link_title}}</a>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
    </section>

@endif
