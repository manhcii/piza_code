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



    <style>
        .cta {
            background-image: url({{$image_background}});
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 100px 20px;
            margin-top: 100px;
        }
    </style>
    <section id="fhm-homepage-cta" class="cta">
        <div class="container">
            <div class="heading-block-m">
                <span class="badge"> {{ $brief }} </span>
                <h2 class="title">{{ $title }}</h2>
                <p class="desc">
                    {{ $content }}
                </p>
                <a href="{{ $url_link }}" title="{{ $url_link_title }}" class="main-button-m">{{ $url_link_title }}</a>
            </div>
        </div>
    </section>
@endif
