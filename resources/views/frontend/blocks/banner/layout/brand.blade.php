@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : null;
        $image_background = $block->image_background != '' ? $block->image_background : null;
        $url_link = $block->url_link ?? '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $style = $block->json_params->style ?? '';
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id && $item->json_params->style != 'decor';
        });
        $block_childs_decor = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id && $item->json_params->style == 'decor';
        });
    @endphp
    <section id="fhm-about-clients" class="clients">
        @if ($block_childs_decor)
            @foreach ($block_childs_decor as $item)
                @php
                    $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                    $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                    $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                    $image = $item->image != '' ? $item->image : null;
                    $image_background = $item->image_background != '' ? $item->image_background : null;
                @endphp
                <div class="decor-element">
                    <img src="{{ $image }}" alt="{{ $title_childs }}" title="{{ $title_childs }}"/>
                </div>
            @endforeach
        @endif
        <div class="container">
            @if ($style == 'title_block')
                <div class="heading-block-m">
                    <h2 class="title">{{ $title }}</h2>
                </div>
            @endif
            <div class="clients-wrapper">
                @if ($block_childs)
                    @foreach ($block_childs as $item)
                        @php
                            $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                            $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                            $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                            $image = $item->image != '' ? $item->image : null;
                            $image_background = $item->image_background != '' ? $item->image_background : null;
                        @endphp
                        <div class="clients-item">
                            <div class="clients-item-image">
                                <img src="{{ $image }}" alt="{{ $title_childs }}" title="{{ $title_childs }}" />
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endif
