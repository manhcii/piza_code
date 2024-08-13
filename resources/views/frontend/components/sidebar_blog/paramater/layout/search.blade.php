@php
    $name = 'post_search';
    $detail_component = $components->first(function ($item) use ($name) {
        return $item->component_code == $name;
    });
@endphp
@isset($component)
    <div class="block block-post-search">
        <div class="block-title">
            <h2>{{$component->title}}</h2>
        </div>
        <div class="block-content">
            <div class="search-from">
                <input type="text" value="{{$request['keyword']??''}}" name="keyword" class="keyword" placeholder="Search...">
                <button class="btn" type="submit">
                    <i class="icon-search"></i>
                </button>
            </div>
        </div>
    </div>
@endisset
