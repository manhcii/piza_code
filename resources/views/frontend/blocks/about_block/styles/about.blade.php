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

    <section id="fhm-about">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-image">
                    @if (count($gallery_image) > 0)
                        @foreach ($gallery_image as $val_img)
                            <div class="decor-element">
                                <img src="{{ $val_img }}" alt="Pizza" title="Pizza" />
                            </div>
                        @endforeach
                    @endif

                    <img src="{{ $image }}" alt="{{ $image }}" title="{{ $image }}" />
                </div>
                <div class="about-content">
                    <div class="heading-block-l">
                        <span class="badge"> {{ $brief }} </span>
                        <h2 class="title">{{ $title }}</h2>
                        <p class="desc">
                            {{ $content }}
                        </p>
                        <ul class="list">
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
                                    <li class="item">
                                        <div class="icon">
                                            <img src="{{ $image_childs }}" alt="{{ $title_childs }}"
                                                title="{{ $title_childs }}" />
                                        </div>
                                        <span class="text">{{ $title_childs }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
