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
    <style>
        #fhm-about-break {
            background: url({{$image_background}}) left no-repeat;
            background-size: cover;
            height: 741px;
            padding-top: 130px;
            position: relative;
        }
    </style>
    <section id="fhm-about-break">
        <div class="container">
            <h2 class="break-title">
                {!! nl2br($title) !!}
            </h2>
        </div>
        <div class="decor-element">
            <img src="{{ $image }}" alt="Pizza" title="Pizza" />
        </div>
    </section>
@endif
