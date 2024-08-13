@isset($feature)
    <div class="block block-posts">
        <div class="block-title">
            <h2>{{$component->title}}</h2>
        </div>
        <div class="block-content">
            <ul class="posts-list">
                @foreach ($feature as $item)
                    @php
                        $title = $item->json_params->name->{$locale} ?? $item->name;
                        $brief = $item->json_params->brief->{$locale} ?? $item->brief;
                        $price = $item->price ?? '0';
                        $price_old = $item->price_old ?? '0';
                        $image = $item->image ?? url('data/images/no_image.jpg');
                        $image_thumb = $item->image_thumb ?? url('data/images/no_image.jpg');
                        $alias = route('frontend.page', ['taxonomy' => $item->alias ?? '']);
                        $time = date('M d, Y', strtotime($item->created_at));
                    @endphp
                    <li class="post-item">
                        <a href="{{ $alias }}" class="post-image">
                            <img src="{{ $image }}">
                        </a>
                        <div class="post-content">
                            <h2 class="post-title">
                                <a href="{{ $alias }}">
                                    {{ $title }}
                                </a>
                            </h2>
                            <div class="post-time">
                                <span class="post-date">{{ $time }}</span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endisset
