@if ($block)
    @php

        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $image = $block->image != '' ? $block->image : '';
        $video = $block->json_params->video ??'';
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
    @endphp

<section class="section section-padding background-1 section-mb-l">
    <div class="section-container">
        <!-- Block Video -->
        <div class="block block-video">
            <div class="section-row">
                <div class="section-column left">
                    <div class="section-column-wrap">
                        <div class="block-widget-wrap">
                            <div class="block-widget-video">
                                <div class="video-thumb">
                                    <img width="565" height="635" class="img-responsive" src="{{$image}}" alt="{{$brief}}">
                                </div>
                                <div class="video-wrap">
                                    <div class="video " data-src="{!!$video!!}" data-toggle="modal" data-target="#video-popup">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </div>
                                    <div class="content-video modal fade" id="video-popup" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always" allow="autoplay"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-column right">
                    <div class="section-column-wrap">
                        <div class="block-widget-wrap">
                            <div class="block-widget-video">
                                <div class="video-text">
                                    <h2 class="title">{!!$brief!!}</h2>
                                    <div class="description">{!!$content!!}</div>
                                    <a href="{{$url_link}}" class="button button-white">{{$url_link_title}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
