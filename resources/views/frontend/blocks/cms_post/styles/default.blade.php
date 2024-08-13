@if ($block)
    @php
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $background = $block->image_background != '' ? $block->image_background : url('assets/img/banner.jpg');
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;

        $params['status'] = App\Consts::STATUS['active'];
        $params['is_featured'] = true;
        $params['is_type'] = App\Consts::TAXONOMY['post'];
        $rows = App\Models\CmsPost::getsqlCmsPost($params)
            ->limit(4)
            ->get();

    @endphp


    <section id="fhm-homepage-news" class="news">
        <div class="container">
            <div class="heading-block-m">
                <span class="badge">{{ $brief }}</span>
                <h2 class="title">{{ $title }}</h2>
            </div>
            <div class="news-slider">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($rows as $item)
                            @php
                                $title_child = $item->json_params->name->{$locale} ?? $item->name;
                                $brief_child = $item->json_params->brief->{$locale} ?? $item->brief;
                                $content_child = $item->json_params->content->{$locale} ?? $item->content;
                                $image_child = $item->image_thumb != '' ? $item->image_thumb : ($item->image != '' ? $item->image : 'data/images/no_image.jpg');
                                $time = date('d.M.Y', strtotime($item->updated_at));
                                $alias = $item->alias ?? '';

                            @endphp

                            <div class="swiper-slide">
                                <div class="news-item">
                                    <div class="news-item-image">
                                        <img src="{{$image_child}}" alt="{{$title_child}}" title="{{$title_child}}" />
                                    </div>
                                    <p class="news-item-date">{{$time}}</p>
                                    <a href="{{$alias}}" title="{{$title_child}}"
                                        class="news-item-title">{{$title_child}}</a>
                                    <p class="news-item-desc">
                                        {{$brief_child}}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
