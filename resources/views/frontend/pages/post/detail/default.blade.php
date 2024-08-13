@extends('frontend.layouts.default')
@section('content')
    @php
        $seo_title = $seo_title ?? ($detail->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')));
        $seo_keyword = $seo_keyword ?? ($detail->json_params->seo_keyword->$locale ?? ($setting->{$locale . '-seo_keyword'} ?? ($setting->seo_keyword ?? '')));
        $seo_description = $seo_description ?? ($detail->json_params->seo_description->$locale ?? ($setting->{$locale . '-seo_description'} ?? ($setting->seo_description ?? '')));
        $seo_image = $seo_image ?? ($detail->json_params->image ?? (json_decode($setting->image)->seo_og_image ?? ''));
        $title = $detail->json_params->name->{$locale} ?? $detail->name;
        $image = $detail->image ?? '';
        $time = date('M d, Y', strtotime($detail->created_at));
        $content = $detail->json_params->content->{$locale} ?? 'Chưa cập nhật';
        $category = $taxonomys->first(function ($item, $key) use ($relationship) {
            return in_array($item->id, $relationship);
        });
        $link = route('frontend.page', ['taxonomy' => $detail->alias ?? '']);

        $time_name = '0 sec';
        $etime = time() - strTotime($detail->created_at);
        if ($etime > 1) {
            foreach (App\Consts::SET_TIME as $secs => $str) {
                $d = $etime / $secs;
                if ($d >= 1) {
                    $r = round($d);
                    $time_name = $r . ' ' . ($r > 1 ? App\Consts::TIME_NAME[$str] : $str);
                    break;
                }
            }
        }
    @endphp

    <style>
        #fhm-blog-detail-banner {
            background: linear-gradient(180deg, #000 0%, rgba(0, 0, 0, 0.67) 0.01%, rgba(0, 0, 0, 0.12) 40.63%, rgba(0, 0, 0, 0.12) 68.75%, rgba(0, 0, 0, 0.76) 100%), url({{ $category->json_params->image_thumb }}) center no-repeat;
            background-size: cover;
            padding: 224px 0;
        }
    </style>
    <section id="fhm-blog-detail-banner" class="banner">
        <div class="container">
            <h1 class="banner-title">
                {{ $title }}
            </h1>
            <span class="banner-author"> @lang('By'): {{ $detail->admin_name }} </span>
        </div>
    </section>
    <section id="fhm-blog-detail-post">
        <div class="container">
            <div class="post-info">
                <span class="date">{{ date('d.M.Y', strTotime($detail->created_at)) }}</span>
                <div class="line"></div>
                <span class="time"> {{ $time_name }} </span>
                <div class="line"></div>
                <span class="author">@lang('By'):{{ $detail->admin_name }}</span>
            </div>
            <h2 class="post-title">
                {{ $title }}
            </h2>
            <div class="content_post">
                {!! $detail->json_params->content->{$locale} ?? $detail->content !!}
                <div class="post-slider">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @if (isset($detail->json_params->gallery_image) && count($detail->json_params->gallery_image) > 0)
                                @foreach ($detail->json_params->gallery_image as $val)
                                    <div class="swiper-slide">
                                        <div class="post-image">
                                            <img src="{{ $val }}" alt="Pizza" title="Pizza" />
                                        </div>
                                    </div>
                                @endforeach
                            @endif


                        </div>
                    </div>
                </div>
            </div>
            <div class="post-footer">
                <div class="post-tag-wrapper">
                    @if (isset($detail->json_params->paramater->tag) && count($detail->json_params->paramater->tag) > 0)
                        @foreach ($detail->json_params->paramater->tag as $item)
                            <div title="{{$item}}" class="post-tag">{{$item}}</div>
                        @endforeach
                    @endif
                </div>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $link }}" target="_blank">
                    <button type="button" class="post-share-button">
                        <span class="icon">
                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.375 6.8663C4.375 7.21148 4.65482 7.4913 5 7.4913C5.34518 7.4913 5.625 7.21148 5.625 6.8663V2.3927L7.65172 4.41942L8.53561 3.53553L5.00007 0L1.46454 3.53553L2.34842 4.41942L4.375 2.39284V6.8663Z"
                                    fill="#6C757D" />
                                <path
                                    d="M0 6.25H1.25V8.75H8.75V6.25H10V8.75C10 9.44035 9.44036 10 8.75 10H1.25C0.559644 10 0 9.44035 0 8.75V6.25Z"
                                    fill="#6C757D" />
                            </svg>
                        </span>
                        <span class="text"> Share </span>
                    </button>
                </a>

            </div>
        </div>
    </section>
@endsection
