@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : null;
        $image_background = $block->image_background != '' ? $block->image_background : null;
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });

    @endphp

    <section id="fhm-homepage-menu">
        <div class="container">
            <div class="heading-block-m">
                <span class="badge"> {{ $brief }} </span>
                <h2 class="title">{{ $title }}</h2>
            </div>
            <div class="menu-wrapper">
                <div class="menu-image-list tab-content">
                    @if ($block_childs)
                        @foreach ($block_childs as $item)
                            @php
                                $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                                $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                                $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                                $image_childs = $item->image != '' ? $item->image : null;
                                $gallery_image = $item->json_params->gallery_image ?? null;
                            @endphp
                            <div class="menu-image tab-pane fade {{ $loop->index == 1 ? 'show active' : '' }}"
                                id="{{ Str::slug($title_childs) }}" role="tabpanel" aria-labelledby="{{ Str::slug($title_childs) }}-tab">
                                @if (count($gallery_image) > 0)
                                    @foreach ($gallery_image as $val)
                                        <div class="decor-element">
                                            <img src="{{ $val }}" alt="{{ $title_childs }}"
                                                title="{{ $title_childs }}" />
                                        </div>
                                    @endforeach
                                @endif
                                <img src="{{ $image_childs }}" alt="{{ $title_childs }}" title="{{ $title_childs }}"
                                    class="menu-image-item" />
                            </div>
                        @endforeach
                    @endif
                </div>
                <ul class="menu-list" role="tablist">
                    @if ($block_childs)
                        @foreach ($block_childs as $item)
                            @php
                                $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                                $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                                $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                                $image = $item->image != '' ? $item->image : null;
                                $image_background = $item->image_background != '' ? $item->image_background : null;
                            @endphp
                            <li class="menu-item {{ $loop->index == 1 ? 'active' : '' }}" id="{{ Str::slug($title_childs) }}-tab"
                                data-bs-toggle="tab" data-bs-target="#{{ Str::slug($title_childs) }}" role="tab"
                                aria-controls="{{ Str::slug($title_childs) }}" aria-selected="false">
                                <h3 class="menu-item-title">{{ $title_childs }}</h3>
                                <p class="menu-item-desc">
                                    {{ $brief_childs }}
                                </p>
                            </li>
                        @endforeach
                    @endif


                </ul>
            </div>
        </div>
    </section>


@endif
