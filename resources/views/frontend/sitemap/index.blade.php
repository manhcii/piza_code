<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="{{ asset('data/files/sitemapindex.xsl') }}" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @isset($sitemap)
        @foreach ($sitemap as $items)
            <sitemap>
                <loc>{{ route('frontend.sitemap.alias', ['type' => $items['name'] ?? '']) }} </loc>
                <lastmod>{{ $items['time']}}</lastmod>
            </sitemap>
        @endforeach
    @endisset
</sitemapindex>
