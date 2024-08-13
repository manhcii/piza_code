@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $image_background = $block->image_background != '' ? $block->image_background : '';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $gallery_image = $block->json_params->gallery_image ?? [];
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
    @endphp

    <section id="fhm-homepage-reason">
        @if (count($gallery_image) > 0)
            @foreach ($gallery_image as $val)
                <div class="decor-element">
                    <img src="{{ $val }}" alt="{{ $title }}" title="{{ $title }}" />
                </div>
            @endforeach
        @endif
        <div class="reason-background">
            <img src="{{ $image_background }}" alt="Background" title="Background" />
        </div>
        <div class="reason-wrapper">
            <div class="reason-content">
                <div class="heading-block-s">
                    <h2 class="title">{{ $title }}</h2>
                    <p class="desc">
                        {{ $brief }}
                    </p>
                </div>
                <a href="{{ $url_link }}" title="{{ $url_link_title }}"
                    class="main-button-s">{{ $url_link_title }}</a>
            </div>
            <div class="reason-image">
                <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
            </div>
        </div>
    </section>


@endif
