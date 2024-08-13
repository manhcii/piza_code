<!DOCTYPE html>
<html lang="{{ $locale ?? 'vi' }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ $seo_title ?? ($page->title ?? ($web_information->information->seo_title ?? '')) }}
    </title>
    <link rel="icon" href="{{ $web_information->image->favicon ?? '' }}" type="image/x-icon">
    {{-- Print SEO --}}
    @php
        $seo_title = $seo_title ?? ($page->title ?? ($web_information->information->seo_title ?? ''));
        $seo_keyword = $seo_keyword ?? ($page->keyword ?? ($web_information->information->seo_keyword ?? ''));
        $seo_description = $seo_description ?? ($page->description ?? ($web_information->information->seo_description ?? ''));
        $seo_image = $seo_image ?? ($page->json_params->og_image ?? ($web_information->image->seo_og_image ?? ''));
    @endphp
    <meta name="description" content="{{ $seo_description }}" />
    <meta name="keywords" content="{{ $seo_keyword }}" />
    <meta name="news_keywords" content="{{ $seo_keyword }}" />
    <meta property="og:image" content="{{ $seo_image }}" />
    <meta property="og:title" content="{{ $seo_title }}" />
    <meta property="og:description" content="{{ $seo_description }}" />
    <meta property="og:url" content="{{ Request::fullUrl() }}" />
    {{-- End Print SEO --}}
    {{-- Include style for app --}}
    @include('frontend.panels.styles')
    {{-- Styles custom each page --}}
    @stack('style')
</head>

<body class="page">
    <div id="page" class="hfeed page-wrapper">

        @isset($widget->header)
            @if (\View::exists('frontend.widgets.header.' . $widget->header->json_params->layout))
                @include('frontend.widgets.header.' . $widget->header->json_params->layout)
            @else
                {{ 'View: frontend.widgets.header.' . $widget->header->json_params->layout . ' do not exists!' }}
            @endif
        @endisset

        <div id="site-main" class="site-main">
            <div id="main-content" class="main-content">
                <div id="primary" class="content-area">
                    <div id="title" class="page-title">
                        <div class="section-container">
                            <div class="content-title-heading">
                                <h1 class="text-title-heading">
                                    Wishlist
                                </h1>
                            </div>
                            <div class="breadcrumbs">
                                <a href="index.html">Home</a><span class="delimiter"></span>Wishlist
                            </div>
                        </div>
                    </div>

                    <div id="content" class="site-content" role="main">
                        <div class="section-padding">
                            <div class="section-container p-l-r">
                                <div class="shop-wishlist">
                                    @if (isset($rows) && count($rows) > 0)
                                        <table class="wishlist-items">
                                            <tbody>
                                                @foreach ($rows as $item)
                                                    @php
                                                        $title = $item->json_params->name->{$locale} ?? $item->name;
                                                        $price = $item->price ?? '0';
                                                        $image = $item->image ?? ($item->image_thumb ?? url('data/images/no_image.jpg'));
                                                        $alias = $item->alias ?? '';
                                                        $time = date('M d,Y', strtotime($item->created_at));
                                                    @endphp
                                                    <tr class="wishlist-item">
                                                        <td class="wishlist-item-remove"><span
                                                                data-id="{{ $item->id }}"></span></td>
                                                        <td class="wishlist-item-image">
                                                            <a
                                                                href="{{ route('frontend.page', ['taxonomy' => $alias]) }}">
                                                                <img width="600" height="600"
                                                                    src="{{ $image }}"
                                                                    alt="{{ $title }}">
                                                            </a>
                                                        </td>
                                                        <td class="wishlist-item-info">
                                                            <div class="wishlist-item-name">
                                                                <a
                                                                    href="{{ route('frontend.page', ['taxonomy' => $alias]) }}">{{ $title }}</a>
                                                            </div>
                                                            <div class="wishlist-item-price">
                                                                <span>${{ $price }}</span>
                                                            </div>
                                                            <div class="wishlist-item-time">{{ $time }}</div>
                                                        </td>
                                                        <td class="wishlist-item-actions">
                                                            <div class="wishlist-item-stock">
                                                                In stock
                                                            </div>
                                                            <div class="wishlist-item-add">
                                                                <div class="btn-add-to-cart add-to-cart"
                                                                    data-title="Add to cart" data-quantity="1"
                                                                    data-id="{{ $item->id }}">
                                                                    <a rel="nofollow" href="javascript:void(0)"
                                                                        class="product-btn button">Add to cart</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="wishlist-empty">There are no products on the wishlist!</div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div><!-- #content -->
                </div><!-- #primary -->
            </div><!-- #main-content -->
        </div>

        @isset($widget->footer)
            @if (\View::exists('frontend.widgets.footer.' . $widget->footer->json_params->layout))
                @include('frontend.widgets.footer.' . $widget->footer->json_params->layout)
            @else
                {{ 'View: frontend.widgets.footer.' . $widget->footer->json_params->layout . ' do not exists!' }}
            @endif
        @endisset
    </div>
    {{-- Include scripts --}}
    @include('frontend.panels.scripts')
    @include('frontend.components.sticky.alert')

    {{-- Scripts custom each page --}}
    @stack('script')

</body>

</html>
