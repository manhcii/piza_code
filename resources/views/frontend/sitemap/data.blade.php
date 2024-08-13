<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="{{ asset('data/files/xml.xsl') }}" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">@php
        $routes = [];
        foreach (App\Consts::ROUTE_NAME as $item) {
            $routes[$item['name']] = $item['title'];
            $routes['show_route'][$item['name']] = isset($item['show_route']) && $item['show_route'] ? $item['show_route'] : false;
        }
    @endphp

    @if (count($data_pages) > 0)
        @foreach ($data_pages as $items)
            @if (isset($routes['show_route'][$items->route_name]) && $routes['show_route'][$items->route_name])
                <url>
                    <loc>{{ route('frontend.page', ['taxonomy' => $items->alias ?? '']) }}</loc>
                    <priority>0.8</priority>
                    <lastmod>{{ $items->created_at->tz('UTC')->toAtomString() }}</lastmod>
                    <changefreq>daily</changefreq>
                </url>
            @endif
        @endforeach
    @endif

    @if (count($data_taxonomy) > 0)
        @foreach ($data_taxonomy as $items)
            @isset(App\Consts::ROUTE_TAXONOMY[$items->taxonomy])
                <url>
                    <loc>
                        {{ route('frontend.page', ['taxonomy' => App\Consts::ROUTE_TAXONOMY[$items->taxonomy], 'alias' => $items->alias ?? '']) }}
                    </loc>
                    <priority>0.8</priority>
                    <lastmod>{{ $items->created_at->tz('UTC')->toAtomString() }}</lastmod>
                    <changefreq>daily</changefreq>
                </url>
            @endisset
        @endforeach
    @endif

    @if (count($data_post) > 0)
        @foreach ($data_post as $items)
            <url>
                <loc>{{ route('frontend.page', ['taxonomy' => $items->alias ?? '']) }}</loc>
                <priority>0.8</priority>
                <lastmod>{{ $items->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>daily</changefreq>
            </url>
        @endforeach
    @endif

</urlset>
