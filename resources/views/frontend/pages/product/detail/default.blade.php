@extends('frontend.layouts.default')

@section('content')
    @php
        $seo_title = $seo_title ?? ($detail->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')));
        $seo_keyword = $seo_keyword ?? ($detail->json_params->seo_keyword->$locale ?? ($setting->{$locale . '-seo_keyword'} ?? ($setting->seo_keyword ?? '')));
        $seo_description = $seo_description ?? ($detail->json_params->seo_description->$locale ?? ($setting->{$locale . '-seo_description'} ?? ($setting->seo_description ?? '')));
        $seo_image = $seo_image ?? ($detail->json_params->image ?? (json_decode($setting->image)->seo_og_image ?? ''));
        $link = route('frontend.page', ['taxonomy' => $detail->alias ?? '']);

        $page_title = $detail->json_params->name->{$locale} ?? $detail->name;
        $page_brief = $detail->json_params->brief->{$locale} ?? $detail->brief;
        $page_description = $detail->json_params->description->{$locale} ?? $detail->description;
        $page_content = $detail->json_params->content->{$locale} ?? $detail->content;
        $page_image = $detail->image != '' ? $detail->image : $setting->background_breadcrumbs;
        $page_backgroud = $detail->image_thumb != '' ? $detail->image_thumb : $setting->background_breadcrumbs;

    @endphp
    <style>
        #fhm-products-banner {
            background: linear-gradient(180deg, #000 0%, rgba(0, 0, 0, 0.67) 0.01%, rgba(0, 0, 0, 0.12) 40.63%, rgba(0, 0, 0, 0.12) 68.75%, rgba(0, 0, 0, 0.76) 100%), url({{ $page_backgroud }}) center no-repeat;
            background-size: cover;
            padding: 269px 0 267px;
        }
    </style>
    <section id="fhm-products-banner" class="banner">
        <div class="container">
            <h1 class="banner-title">{{$page_title}}</h1>
        </div>
    </section>
@endsection
