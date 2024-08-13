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
        $block_hot = $rows->take(3);
        $block_pich = $rows->random();
    @endphp

    <style>
        #fhm-blog-banner {
            background: linear-gradient(180deg, #000 0%, rgba(0, 0, 0, 0.67) 0.01%, rgba(0, 0, 0, 0.12) 40.63%, rgba(0, 0, 0, 0.12) 68.75%, rgba(0, 0, 0, 0.76) 100%), url({{ $category_backgroud }}) center no-repeat;
            background-size: cover;
            padding: 242px 0 294px;
        }

        #fhm-blog-relate-news .relate-news-wrapper .relate-news-interest-image {
            width: 520px;
            height: 623px;
        }
    </style>

    <section id="fhm-blog-banner" class="banner">
        <div class="container">
            <h1 class="banner-title">{{ $category_brief }}</h1>
        </div>
    </section>

    <section id="fhm-blog-hot-news">
        <div class="container">
            <div class="hot-news-wrapper">
                <div class="hot-news-thumb">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach ($block_hot as $items)
                                <div class="swiper-slide">
                                    <div class="hot-news-thumb-item">
                                        <div class="line"></div>
                                        <span class="number">{{ '0' . ($loop->index + 1) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="hot-news-content">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach ($block_hot as $items)
                                <div class="swiper-slide">
                                    <div class="hot-news-content-item">
                                        <span class="date"> {{ date('d.M.Y', strTotime($items->updated_at)) }} </span>
                                        <a href="{{ route('frontend.page', ['taxonomy' => $items->alias ?? '']) }}"
                                            title="{{ $items->json_params->name->{$locale} ?? $items->name }}"
                                            class="title">{{ $items->json_params->name->{$locale} ?? $items->name }}</a>
                                        <p class="desc">
                                            {{ $items->json_params->brief->{$locale} ?? $items->brief }}
                                        </p>
                                        <span class="author"> @lang('By'): {{ $items->admin_name }} </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="fhm-blog-latest-news" class="news">
        <div class="container">
            <div class="heading-block-s">
                <h2 class="title">{{ $category_description }}</h2>
            </div>
            <ul class="latest-news-tab" role="tablist">
                <li class="latest-news-tab-item active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane"
                    role="tab" aria-controls="all-tab-pane" aria-selected="true">
                    @lang('Show All')
                </li>
                @foreach ($taxonomys as $val_taxonomy)
                    <li class="latest-news-tab-item" id="{{ $val_taxonomy->alias }}-tab" data-bs-toggle="tab"
                        data-bs-target="#{{ $val_taxonomy->alias }}-tab-pane" role="tab"
                        aria-controls="{{ $val_taxonomy->alias }}-tab-pane" aria-selected="false">
                        {{ $val_taxonomy->json_params->name->{$locale} ?? $val_taxonomy->name }}
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                <div class="latest-news-group tab-pane fade show active" id="all-tab-pane" role="tabpanel"
                    aria-labelledby="all-tab" data-perpage="{{ $rows->withQueryString()->perPage() }}"
                    data-currentpage="{{ $rows->withQueryString()->currentPage() }}"
                    data-taxonomy="0" data-lastpage="{{ $rows->withQueryString()->lastPage() }}">
                    <ul class="news-list">
                        @foreach ($rows as $item_post)
                            <li class="news-item">
                                <div class="news-item-image">
                                    <img src="{{ $item_post->image ?? '' }}"
                                        alt="{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}"
                                        title="{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}" />
                                </div>
                                <p class="news-item-date">29.Jun.2021</p>
                                <a href="{{ route('frontend.page', ['taxonomy' => $item_post->alias ?? '']) }}"
                                    title="{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}"
                                    class="news-item-title">{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}</a>
                                <p class="news-item-desc">
                                    {{ $item_post->json_params->brief->{$locale} ?? $item_post->brief }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                    @if ($rows->withQueryString()->currentPage() < $rows->withQueryString()->lastPage())
                        <button type="button" onclick="loadMore('.latest-news-group','.news-list','post')" class="main-button-m">
                            @lang('View More')
                        </button>
                    @endif
                </div>
                @foreach ($taxonomys as $val_taxonomy)
                    @php
                        $data_relationship['id'] = $val_taxonomy->id;
                        $list_posts = App\Models\CmsRelationship::getCmsProduct($data_relationship)->paginate(App\Consts::PAGINATE['post']);
                    @endphp

                    <div class="latest-news-group tab-pane fade" id="{{ $val_taxonomy->alias }}-tab-pane" role="tabpanel"
                        aria-labelledby="{{ $val_taxonomy->alias }}-tab"
                        data-perpage="{{ $list_posts->withQueryString()->perPage() }}"
                        data-currentpage="{{ $list_posts->withQueryString()->currentPage() }}"
                        data-taxonomy="{{ $val_taxonomy->id }}"
                        data-lastpage="{{ $list_posts->withQueryString()->lastPage() }}">

                        <ul class="news-list">
                            @foreach ($list_posts as $item_post)
                                <li class="news-item">
                                    <div class="news-item-image">
                                        <img src="{{ $item_post->image ?? '' }}"
                                            alt="{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}"
                                            title="{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}" />
                                    </div>
                                    <p class="news-item-date">29.Jun.2021</p>
                                    <a href="{{ route('frontend.page', ['taxonomy' => $item_post->alias ?? '']) }}"
                                        title="{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}"
                                        class="news-item-title">{{ $item_post->json_params->name->{$locale} ?? $item_post->name }}</a>
                                    <p class="news-item-desc">
                                        {{ $item_post->json_params->brief->{$locale} ?? $item_post->brief }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                        @if ($list_posts->withQueryString()->currentPage() < $list_posts->withQueryString()->lastPage())
                            <button type="button" onclick="loadMore('.latest-news-group','.news-list','post')" class="main-button-m">
                                @lang('View More')
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section id="fhm-blog-relate-news">
        <div class="container">
            <div class="heading-block-s">
                <h2 class="title">@lang('Editor’s Picks')</h2>
            </div>
            <div class="relate-news-wrapper">
                <ul class="relate-news-list">
                    @foreach ($block_hot as $items)
                        <li class="relate-news-item">
                            <div class="relate-news-item-image">
                                <img src="{{ $items->image ?? '' }}"
                                    alt="{{ $items->json_params->name->{$locale} ?? $items->name }}"
                                    title="{{ $items->json_params->name->{$locale} ?? $items->name }}" />
                            </div>
                            <div class="relate-news-item-content">
                                <span class="date"> {{ date('d.M.Y', strTotime($items->updated_at)) }} </span>
                                <a href="{{ $items->alias }}"
                                    title="{{ $items->json_params->name->{$locale} ?? $items->name }}"
                                    class="title">{{ $items->json_params->name->{$locale} ?? $items->name }}</a>
                                <p class="desc">
                                    {{ $items->json_params->brief->{$locale} ?? $items->brief }}
                                </p>
                                <span class="author"> @lang('By'): {{ $items->admin_name }} </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="relate-news-interest">
                    <div class="relate-news-interest-image">
                        <img src="{{ $block_pich->image ?? '' }}"
                            alt="{{ $block_pich->json_params->name->{$locale} ?? $block_pich->name }}"
                            title="{{ $block_pich->json_params->name->{$locale} ?? $block_pich->name }}" />
                    </div>
                    <div class="relate-news-interest-content">
                        <span class="date">{{ date('d.M.Y', strTotime($block_pich->updated_at)) }}</span>
                        <a href="{{ route('frontend.page', ['taxonomy' => $block_pich->alias ?? ''])}}"
                            title="{{ $block_pich->json_params->name->{$locale} ?? $block_pich->name }}"
                            class="title">{{ $block_pich->json_params->name->{$locale} ?? $block_pich->name }}</a>
                        <p class="desc">
                            {{ $block_pich->json_params->brief->{$locale} ?? $block_pich->brief }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
