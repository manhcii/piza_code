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
            ->where('is_featured', 1)
            ->get();
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id && $item->json_params->style != 'decor';
        });
    @endphp
    <section id="fhm-bestsell">
        <div class="container">
            <div class="bestsell-content text-center">
                <p class="sub-title">Deals of the Day</p>
                <h3 class="title"><a href="/">Best Sellers</a></h3>
            </div>
            <div class="swiper home-product">
                <div class="swiper-wrapper">
                    @foreach($rows as $item)
                    @php
                $id = $item->id ?? 0;
                $quantity = $item->json_params->quantity ?? 1;
                $title = $item->json_params->name->{$locale} ?? $item->name;
                $brief = $item->json_params->brief->{$locale} ?? $item->brief;
                $price = $item->price ?? null;
                $price_old = $item->price_old ?? null;
                $image = $item->image ?? url('themes/admin/img/no_image.jpg');
                $image_thumb = $item->image_thumb ?? $item->image;
                $date = date('H:i d/m/Y', strtotime($item->created_at));
                $alias = route('frontend.page', ['taxonomy' => $item->alias ?? '']);
                $category = App\Models\CmsTaxonomy::getTaxonomyByPostId($id, $item->is_type);
              @endphp
                    <div class="swiper-slide">
                        <div class="product-item">
                            <div class="product-img">
                                <a href="{{ $item->alias }}" title="Empire Design">
                                    <img src="{{ $item->image }}" alt="Empire Design"
                                        title="Empire Design" />
                                </a>
                                <div class="product-wishlist liked">
                                    <div class="product-wishlist-hidden">
                                        <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.33331 0.833374C7.74196 0.833374 9.02693 1.53456 9.99998 2.33337C10.973 1.53456 12.258 0.833374 13.6666 0.833374C16.7042 0.833374 19.1666 3.09212 19.1666 5.87825C19.1666 11.4959 12.7728 14.7676 10.665 15.6935C10.2405 15.88 9.7595 15.88 9.33493 15.6935C7.22713 14.7675 0.833313 11.4957 0.833313 5.87812C0.833313 3.09198 3.29575 0.833374 6.33331 0.833374Z"
                                                fill="#769496" stroke="#769496" stroke-width="1.5" />
                                        </svg>
                                    </div>
                                    <div class="product-wishlist-show">
                                        <svg width="20" height="17" viewBox="0 0 20 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6.33331 0.833374C7.74196 0.833374 9.02693 1.53456 9.99998 2.33337C10.973 1.53456 12.258 0.833374 13.6666 0.833374C16.7042 0.833374 19.1666 3.09212 19.1666 5.87825C19.1666 11.4959 12.7728 14.7676 10.665 15.6935C10.2405 15.88 9.7595 15.88 9.33493 15.6935C7.22713 14.7675 0.833313 11.4957 0.833313 5.87812C0.833313 3.09198 3.29575 0.833374 6.33331 0.833374Z"
                                                fill="white" stroke="#769496" stroke-width="1.5" />
                                        </svg>
                                    </div>
                                </div>
                                <button class="main-btn position-absolute add-to-cart " data-id="{{ $id }}"
                                data-quantity = 1 data-bs-toggle="offcanvas"
                                    data-bs-target="#cart-popup" aria-controls="cart-popup">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M1.72117 1.54131C1.33081 1.54131 0.949755 1.54596 0.568694 1.54131C0.159752 1.53666 -0.109779 1.14631 0.0435745 0.77919C0.131869 0.560777 0.303811 0.435306 0.540812 0.430659C1.10776 0.426012 1.67935 0.421365 2.24629 0.430659C2.53906 0.435306 2.75282 0.649072 2.78535 0.946485C2.8597 1.62496 2.92941 2.30808 2.99912 2.98655C3.00841 3.05626 3.0177 3.12596 3.03165 3.21426C3.106 3.21426 3.18035 3.21426 3.2547 3.21426C7.11643 3.21426 10.9781 3.21426 14.8399 3.21426C15.4347 3.21426 15.9041 3.56279 15.9877 4.11579C16.0202 4.33885 15.9831 4.57585 15.9366 4.79891C15.5137 6.79251 15.0908 8.78611 14.654 10.7797C14.4774 11.5976 13.8175 12.1181 12.981 12.1181C10.1184 12.1181 7.25119 12.1181 4.38859 12.1181C3.45918 12.1181 2.77141 11.4768 2.67847 10.5566C2.51582 8.9534 2.33923 7.35016 2.17194 5.75156C2.02788 4.38068 1.88382 3.00979 1.7444 1.63425C1.73511 1.61566 1.73046 1.59243 1.72117 1.54131ZM3.13853 4.3342C3.20823 4.97085 3.27329 5.58427 3.33835 6.20233C3.48706 7.61969 3.63577 9.03705 3.78912 10.4544C3.83094 10.8262 4.03541 11.0074 4.41647 11.0074C7.26513 11.0074 10.1091 11.0074 12.9578 11.0074C13.311 11.0074 13.5062 10.8494 13.5805 10.5009C13.9383 8.83258 14.2962 7.15963 14.654 5.49133C14.7376 5.11027 14.8166 4.72456 14.9003 4.3342C10.9735 4.3342 7.06531 4.3342 3.13853 4.3342Z"
                                            fill="black" />
                                        <path
                                            d="M3.34302 14.9107C3.34302 13.9906 4.0912 13.2378 5.00667 13.2378C5.92679 13.2378 6.67962 13.986 6.67962 14.9014C6.67962 15.8216 5.93144 16.5744 5.01597 16.5744C4.10049 16.579 3.34302 15.8262 3.34302 14.9107ZM5.00667 15.4591C5.30873 15.4591 5.56432 15.2128 5.56432 14.9107C5.56897 14.6087 5.32267 14.3531 5.02061 14.3484C4.71391 14.3438 4.45367 14.5994 4.45367 14.9061C4.45832 15.2082 4.70926 15.4591 5.00667 15.4591Z"
                                            fill="black" />
                                        <path
                                            d="M11.6892 16.5746C10.7737 16.5746 10.0209 15.8218 10.0209 14.9017C10.0209 13.9862 10.7737 13.2334 11.6938 13.2334C12.6139 13.2334 13.3621 13.9862 13.3621 14.9063C13.3621 15.8265 12.6093 16.5746 11.6892 16.5746ZM11.6892 14.3487C11.3871 14.3487 11.1362 14.5996 11.1362 14.9017C11.1362 15.2038 11.3825 15.4547 11.6845 15.4593C11.9912 15.464 12.2515 15.2038 12.2468 14.8971C12.2468 14.595 11.9912 14.3487 11.6892 14.3487Z"
                                            fill="black" />
                                    </svg>
                                </button>
                            </div>
                            <div class="product-info">
                                <span class="product-type">{{ $category->name }}</span>
                                <a href="{{ $item->alias }}" class="product-name text-2-line text-short" title="Empire Design">
                                   {{$item->name}}
                                </a>
                                <div class="product-price">
                                    <span class="product-price-current">$ {{ number_format($price, 0, ",", ".") }}</span>
                                    <span class="product-price-old">$ {{ number_format($price_old, 0, ",", ".") }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <div class="button button-viewmore">
                        <a href="{{ route('frontend.page',['taxonomy' => 'product-category/products']) }}" title="View All Products">View All Products</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
