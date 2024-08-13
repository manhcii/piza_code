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
    <style>
        #fhm-services-commitment::after {
            content: "";
            width: 90%;
            height: 90%;
            position: absolute;
            top: 50%;
            left: 0;
            z-index: -1;
            transform: translateY(-50%);
            background-image: url({{$image_background}});
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <section id="fhm-services-commitment">
        @if (count($gallery_image) > 0)
            @foreach ($gallery_image as $val)
                <div class="decor-element">
                    <img src="{{ $val }}" alt="{{ $title }}" title="{{ $title }}" />
                </div>
            @endforeach
        @endif
        <div class="container">
            <div class="services-commitment-content">
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
                                @endphp

                                <li class="item">
                                    <div class="icon">
                                        <img src="{{ asset('themes/frontend/assets/images/elements/icons/checked.svg')}}" alt="Checked"
                                            title="Checked" />
                                    </div>
                                    <span class="text">{{ $title_childs }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="services-commitment-image">
            <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
        </div>
    </section>
@endif
