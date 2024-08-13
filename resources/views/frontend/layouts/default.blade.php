<!DOCTYPE html>
<html lang="{{ $locale ?? 'vi' }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ $page->json_params->name->$locale ?? ($page->name ?? ($page->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')))) }}
    </title>
    <link rel="icon" href="{{ json_decode($setting->image)->favicon ?? '' }}" type="image/x-icon">
    {{-- Print SEO --}}
    @php
        $seo_title = $seo_title ?? ($page->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')));
        $seo_keyword = $seo_keyword ?? ($page->json_params->seo_keyword->$locale ?? ($setting->{$locale . '-seo_keyword'} ?? ($setting->seo_keyword ?? '')));
        $seo_description = $seo_description ?? ($page->json_params->seo_description->$locale ?? ($setting->{$locale . '-seo_description'} ?? ($setting->seo_description ?? '')));
        $seo_image = $seo_image ?? ($page->json_params->image ?? (json_decode($setting->image)->seo_og_image ?? ''));
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

    @stack('schema')
</head>

<body>

    @isset($widget->header)
        @if (\View::exists('frontend.widgets.header.' . $widget->header->json_params->layout))
            @include('frontend.widgets.header.' . $widget->header->json_params->layout)
        @else
            {{ 'View: frontend.widgets.header.' . $widget->header->json_params->layout . ' do not exists!' }}
        @endif
    @endisset

    <main>
        @if (isset($blocks_selected))
            @foreach ($blocks_selected as $block)
                @if (\View::exists('frontend.blocks.' . $block->block_code . '.index'))
                    @include('frontend.blocks.' . $block->block_code . '.index')
                @else
                    {{ 'View: frontend.blocks.' . $block->block_code . '.index do not exists!' }}
                @endif
            @endforeach
        @endif
    </main>




    @isset($widget->footer)
        @if (\View::exists('frontend.widgets.footer.' . $widget->footer->json_params->layout))
            @include('frontend.widgets.footer.' . $widget->footer->json_params->layout)
        @else
            {{ 'View: frontend.widgets.footer.' . $widget->footer->json_params->layout . ' do not exists!' }}
        @endif
    @endisset

    @include('frontend.panels.scripts')
    @include('frontend.components.sticky.alert')
    {{-- Include scripts --}}
    @stack('script')

</body>

</html>
