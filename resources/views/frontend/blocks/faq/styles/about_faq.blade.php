@if ($block)
    @php
        
        $title = $block->json_params->title->{$locale} ?? $block->title;
        $brief = $block->json_params->brief->{$locale} ?? $block->brief;
        $content = $block->json_params->content->{$locale} ?? $block->content;
        $url_link = $block->url_link != '' ? $block->url_link : '';
        $url_link_title = $block->json_params->url_link_title->{$locale} ?? $block->url_link_title;
        // Filter all blocks by parent_id
        $block_childs = $blocks->filter(function ($item, $key) use ($block) {
            return $item->parent_id == $block->id;
        });
    @endphp

    <div class="section-padding">
        <div class="section-container p-l-r">
            <div class="page-faq">
                <div class="row">
                    @if ($block_childs)
                        @foreach ($block_childs as $items)
                            @php
                                $title_childs = $items->json_params->title->{$locale} ?? $items->title;
                                $brief_childs = $items->json_params->brief->{$locale} ?? $items->brief;
                                $content_childs = $items->json_params->content->{$locale} ?? $items->content;
                                $url_link = $items->url_link != '' ? $items->url_link : '';
                                $url_link_title = $items->json_params->url_link_title->{$locale} ?? $items->url_link_title;
                                $block_childs2 = $blocks->filter(function ($item, $key) use ($items) {
                                    return $item->parent_id == $items->id;
                                });
                                
                            @endphp
                            <div class="col-md-6">
                                <div class="faq-section">
                                    <div class="section-title">
                                        <h2>{{ $title_childs }}</h2>
                                    </div>
                                    <div class="section-content">
                                        @if ($block_childs2)
                                            @foreach ($block_childs2 as $item)
                                                @php
                                                    $title_childs = $item->json_params->title->{$locale} ?? $item->title;
                                                    $brief_childs = $item->json_params->brief->{$locale} ?? $item->brief;
                                                    $content_childs = $item->json_params->content->{$locale} ?? $item->content;
                                                    $url_link = $item->url_link != '' ? $item->url_link : '';
                                                    $url_link_title = $item->json_params->url_link_title->{$locale} ?? $item->url_link_title;
                                                    
                                                @endphp
                                                 <div class="faq-item">
                                                    <div class="faq-question">
                                                       {{$brief_childs}}
                                                    </div>
                                                    <div class="faq-answer">
                                                        {{$content_childs}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                       
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>
        </div>
    </div>

@endif
