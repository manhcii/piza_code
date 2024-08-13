@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $image = $block->image != '' ? $block->image : url('demos/barber/images/icons/comb3.svg');
        $background = $block->image_background != '' ? $block->image_background : url('demos/seo/images/sections/5.jpg');
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;

        $params['taxonomy'] = App\Consts::TAXONOMY['product'];
        $params['status'] = App\Consts::STATUS['active'];
        $params['is_featured'] = true;
        $params['is_type'] = App\Consts::TAXONOMY['product'];
        $params['user_id'] = $user_auth->id ?? '';
        // list product
        $rows = App\Models\CmsProduct::getsqlCmsProduct($params)
            ->limit(10)
            ->get();

    @endphp

<section id="fhm-homepage-product">
    <div class="container">
        <div class="heading-block-m">
            <span class="badge"> {{ $brief }} </span>
            <h2 class="title">{{ $title }}</h2>
            <div class="product-slider">
                <div class="slick-slider">
                    @foreach ($rows as $item)
                        @php
                            $title_child = $item->json_params->name->{$locale} ?? $item->name;
                            $brief_child = $item->json_params->brief->{$locale} ?? $item->brief;
                            $content_child = $item->json_params->content->{$locale} ?? $item->content;
                            $image_child = $item->image_thumb != '' ? $item->image_thumb : ($item->image != '' ? $item->image : 'data/images/no_image.jpg');
                            $price = $item->price != '' ? $item->price : 0;
                            $time = date('d.M.Y', strtotime($item->updated_at));
                            $alias = $item->alias ?? '';

                        @endphp
                        <div class="product-item">
                            <div class="product-item-image">
                                <img src="{{ $image_child}}" alt="{{ $title_child}}" title="{{ $title_child}}" />
                            </div>
                            <div class="product-item-content">
                                <a href="{{ $alias}}" title="{{ $title_child}}"
                                    class="product-item-content-title">{{ $title_child}}</a>
                                <span class="product-item-content-price"> ${{ number_format($price,2)}} </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="slider-button-next slider-button-next-l">
                    <svg width="13" height="20" viewBox="0 0 13 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L11 11L1 19" stroke="#CF3031" stroke-width="2" />
                    </svg>
                </div>
                <div class="slider-button-prev slider-button-prev-l">
                    <svg width="13" height="20" viewBox="0 0 13 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1L2 11L12 19" stroke="#CF3031" stroke-width="2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
