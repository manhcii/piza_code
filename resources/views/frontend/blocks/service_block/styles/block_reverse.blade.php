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
        $style = $block->json_params->style ?? '';
        $gallery_image = $block->json_params->gallery_image ?? [];
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });

    @endphp

    @if ($style == 'reverse')
        <section class="services-block-4">
            <div class="decor-element">
                <img src="{{ $gallery_image[0] }}" alt="Carrot" title="Carrot" />
            </div>
            <div class="container">
                <div class="services-block-wrapper">
                    <div class="services-block-image">
                        <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
                    </div>
                    <div class="services-block-content">
                        <div class="decor-element">
                            @if ($gallery_image[0])
                                <img src="{{ $gallery_image[1] }}" alt="Spices" title="Spices" />
                            @endif
                        </div>
                        <div class="heading-block-s">
                            <h3 class="title">
                                {{ $title }}
                            </h3>
                            <p class="desc">
                                {{ $brief }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="services-block-3">
            <div class="decor-element">
                <img src="{{ $gallery_image[0] }}" alt="Cutting Board" title="Cutting Board" />
            </div>
            <div class="container">
                <div class="services-block-wrapper">
                    <div class="services-block-content">
                        <div class="heading-block-s">
                            <h3 class="title">
                                {{ $title }}
                            </h3>
                            <p class="desc">
                                {{ $brief }}
                            </p>
                        </div>
                    </div>
                    <div class="services-block-image">
                        <div class="decor-element">
                            @if ($gallery_image[0])
                                <img src="{{ $gallery_image[1] }}??''" alt="Potato" title="Potato" />
                            @endif
                        </div>
                        <div class="decor-element">
                            @if ($gallery_image[0])
                                <img src="{{ $gallery_image[2] }}?''" alt="Grape" title="Grape" />
                            @endif
                        </div>
                        <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- START SERVICE BLOCK 1 -->
@endif
