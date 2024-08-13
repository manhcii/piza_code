{{-- Check và gọi template tương ứng --}}
@extends('frontend.layouts.default')

@section('content')
    @php
        $seo_title = $seo_title ?? ($page->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')));
        $seo_keyword = $seo_keyword ?? ($page->json_params->seo_keyword->$locale ?? ($setting->{$locale . '-seo_keyword'} ?? ($setting->seo_keyword ?? '')));
        $seo_description = $seo_description ?? ($page->json_params->seo_description->$locale ?? ($setting->{$locale . '-seo_description'} ?? ($setting->seo_description ?? '')));
        $seo_image = $seo_image ?? ($page->json_params->image ?? (json_decode($setting->image)->seo_og_image ?? ''));
        $background_breadcrumbs = json_decode($setting->image)->background_breadcrumbs ?? '';
        $category_title = $page->json_params->name->{$locale} ?? $page->name;
        $category_brief = $page->json_params->brief->{$locale} ?? $page->brief;
        $category_description = $page->json_params->description->{$locale} ?? $page->description;
        $category_content = $page->json_params->content->{$locale} ?? $page->content;
        $category_image = $page->json_params->image != '' ? $page->json_params->image : $setting->background_breadcrumbs;
        $category_backgroud = $page->json_params->image_thumb != '' ? $page->json_params->image_thumb : $setting->background_breadcrumbs;
    @endphp

    <div id="fhm-products-content">
        <style>
            #fhm-products-banner {
                background: linear-gradient(180deg, #000 0%, rgba(0, 0, 0, 0.67) 0.01%, rgba(0, 0, 0, 0.12) 40.63%, rgba(0, 0, 0, 0.12) 68.75%, rgba(0, 0, 0, 0.76) 100%), url({{ $category_backgroud }}) center no-repeat;
                background-size: cover;
                padding: 269px 0 267px;
            }
        </style>
        <section id="fhm-products-banner" class="banner">
            <div class="container">
                <h1 class="banner-title">{{ $category_brief }}</h1>
            </div>
        </section>

        <section id="fhm-products">
            <div class="container">
                <div class="heading-block-m">
                    <h2 class="title">{{ $category_description }}</h2>
                </div>
                <div class="products-wrapper">
                    <div class="products-slider" role="tablist">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($taxonomys as $val_taxonomy)
                                    <div class="swiper-slide">
                                        <div class="products-slide-item {{ Request::segment(2) == $val_taxonomy->alias ? 'active' : '' }}"
                                            id="{{ Str::slug($val_taxonomy->name) }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#{{ Str::slug($val_taxonomy->name) }}-tab-pane" role="tab"
                                            aria-controls="{{ Str::slug($val_taxonomy->name) }}-tab-pane"
                                            aria-selected="false">
                                            <div class="image">
                                                <img src="{{ $val_taxonomy->json_params->image }}"
                                                    alt="{{ $val_taxonomy->name }}" title="{{ $val_taxonomy->name }}" />
                                            </div>
                                            <p class="text">
                                                {{ $val_taxonomy->json_params->name->{$locale} ?? $val_taxonomy->name }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="slider-button-next slider-button-next-m">
                            <svg width="12" height="17" viewBox="0 0 12 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.69231 1.23077L10 9.53847L1.69231 16.1846" stroke="#CF3031" stroke-width="2" />
                            </svg>
                        </div>
                        <div class="slider-button-prev slider-button-prev-m">
                            <svg width="12" height="17" viewBox="0 0 12 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3077 1.23077L2 9.53847L10.3077 16.1846" stroke="#CF3031" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                    <div class="tab-content">
                        @foreach ($taxonomys as $val_taxonomy)
                            @php
                                $data_relationship['id'] = $val_taxonomy->id;
                                $list_product = App\Models\CmsRelationship::getCmsProduct($data_relationship)->paginate(App\Consts::PAGINATE['product']);
                            @endphp

                            <div class="products-group tab-pane fade {{ Request::segment(2) == $val_taxonomy->alias ? 'active show' : '' }}"
                                id="{{ Str::slug($val_taxonomy->name) }}-tab-pane" role="tabpanel"
                                aria-labelledby="{{ Str::slug($val_taxonomy->name) }}-tab"
                                data-perpage="{{ $list_product->withQueryString()->perPage() }}"
                                data-currentpage="{{ $list_product->withQueryString()->currentPage() }}"
                                data-taxonomy="{{ $val_taxonomy->id }}"
                                data-lastpage="{{ $list_product->withQueryString()->lastPage() }}">

                                <ul class="products-list">
                                    @foreach ($list_product as $item_product)
                                        <li class="products-item">
                                            <div class="image">
                                                <img src="{{ $item_product->image ?? '' }}"
                                                    alt="{{ $item_product->json_params->name->{$locale} ?? $item_product->name }}"
                                                    title="{{ $item_product->json_params->name->{$locale} ?? $item_product->name }}" />
                                            </div>
                                            <a href=" {{ route('frontend.page', ['taxonomy' => $item_product->alias ?? ''])  }}"
                                                title="{{ $item_product->json_params->name->{$locale} ?? $item_product->name }}"
                                                class="name">{{ $item_product->name }}</a>
                                            <span class="price"> ${{ number_format($item_product->price, 2) }} </span>
                                        </li>
                                    @endforeach
                                </ul>
                                @if ($list_product->withQueryString()->currentPage() < $list_product->withQueryString()->lastPage())
                                    <button type="button" onclick="loadMore('.products-group','.products-list','product')" class="main-button-m">
                                        @lang('View More')
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
@endpush
