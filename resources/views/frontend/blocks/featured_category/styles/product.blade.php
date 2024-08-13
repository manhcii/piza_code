@if ($block)
    @php

        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $image_background = $block->image_background != '' ? $block->image_background : '';
        $icon = $block->icon != '' ? $block->icon : '';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        $map = $block->json_params->map ?? '';
        $gallery_image = $block->json_params->gallery_image ?? [];
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
        $params['taxonomy'] = App\Consts::TAXONOMY['product'];
        $params['status'] = App\Consts::STATUS['active'];
        // list Category
        $rows = App\Models\ProductCategory::getSqlTaxonomy($params)
            ->limit(9)
            ->get();
    @endphp

    <section id="fhm-menu">
        <div class="container">
            <div class="heading-block-m">
                <h2 class="title">Our Menu</h2>
            </div>
            <ul class="menu-list">
                @if (isset($rows) && count($rows) > 0)
                    @foreach ($rows as $items)
                        <li class="menu-item">
                            <div class="menu-item-image">
                                <a href="{{route('frontend.page', ['taxonomy' => App\Consts::ROUTE_TAXONOMY['product'], 'alias' => $items->alias ?? ''])}}" title="{{ $items->json_params->name->$locale ?? $items->name }}">
                                    <img src="{{ $items->json_params->image??'' }}" alt="Salad" title="{{ $items->json_params->name->$locale ?? $items->name }}" />
                                </a>
                            </div>
                            <a href="{{route('frontend.page', ['taxonomy' => App\Consts::ROUTE_TAXONOMY['product'], 'alias' => $items->alias ?? ''])}}" title="{{ $items->json_params->name->$locale ?? $items->name }}" class="menu-item-title">{{ $items->json_params->name->$locale ?? $items->name }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </section>
@endif
