@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : null;
        $image_background = $block->image_background != '' ? $block->image_background : null;
        $url_link = $block->url_link ?? '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
    @endphp


    <style>
        #fhm-about-maps {
            background: url({{$image_background}}) center no-repeat;
            background-size: cover;
            padding: 70px 0;
            margin-top: 100px;
        }
    </style>
    <section id="fhm-about-maps">
        <div class="container">
            <div class="maps-image">
                <img src="{{ $image }}" alt="{{ $title }}" title="{{ $title }}" />
            </div>
        </div>
    </section>
@endif
