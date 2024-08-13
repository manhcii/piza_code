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

    <section id="fhm-notfound">
        <div class="container">
            <div class="notfound-wrapper">
                @if (count($gallery_image) > 0)
                    @foreach ($gallery_image as $val)
                        <div class="decor-element">
                            <img src="{{ $val }}" alt="{{ $title }}" title="{{ $title }}" />
                        </div>
                    @endforeach
                @endif
                <div class="notfound-image">
                    <img src="{{$image}}" alt="{{ $title }}" title="{{ $title }}" />
                </div>
                <h1 class="notfound-title">{{ $title }}</h1>
                <a href="{{ route('home.default') }}" title="{{ $url_link_title }}" class="notfound-button">{{ $url_link_title }}</a>
            </div>
        </div>
    </section>


@endif
