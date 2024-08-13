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
        $i = 0;
        // dd($block_childs);
    @endphp

    <div class="container margin-service">
        <div class="heading-block-m">
            <span class="badge"> {{ $brief }} </span>
            <h2 class="title">{{ $title }}</h2>
            <p class="desc">
                {{ $content }}
            </p>
        </div>
    </div>
    <!-- START SERVICE BLOCK 1 -->
    <section class="services-block-1">
        <div class="container">
            <div class="services-block-wrapper">
                <div class="decor-element">
                    <img src="{{ $gallery_image[0] }}" alt="Tomatos" title="Tomatos" />
                </div>
                <div class="services-block-content">
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
                                $style = $item->json_params->style ?? '';

                            @endphp
                            @if ($style == 'content')
                                <div class="heading-block-s">
                                    <h3 class="title">
                                        {{ $title_childs }}
                                    </h3>
                                    <p class="desc">
                                        {{ $brief_childs }}
                                    </p>
                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>

                <div class="services-block-image">

                    @if ($block_childs)
                        @foreach ($block_childs as $item)
                            @if ($item->json_params->style == 'image')
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
                                    $i++;
                                @endphp
                                <div class="services-block-image-item">
                                    @if ($i == 1)
                                        <div class="decor-element">
                                            <img src="{{ $gallery_image[1] }}" alt="Plant" title="Plant" />
                                        </div>
                                    @endif
                                    <img src="{{ $image_childs }}" alt="{{ $image_background_childs }}" />
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

@endif
