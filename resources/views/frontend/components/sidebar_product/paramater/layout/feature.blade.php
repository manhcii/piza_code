@isset($feature)
    <div class="block block-products">
        <div class="block-title">
            <h2>{{$component->title}}</h2>
        </div>
        <div class="block-content">
            <ul class="products-list">
                @foreach ($feature as $item)
                    @php
                        $title = $item->name ?? '';
                        $brief = $item->json_params->brief->{$locale} ?? $item->brief;
                        $price = $item->price ?? '0';
                        $price_old = $item->price_old ?? '0';
                        $image = $item->image ?? url('data/images/no_image.jpg');
                        $image_thumb = $item->image_thumb ?? url('data/images/no_image.jpg');
                        $alias = $item->alias ?? '';
                    @endphp
                    <li class="product-item">
                        <a href="{{ route('frontend.page', ['taxonomy' => $alias]) }}" class="product-image">
                            <img src="{{ $image }}">
                        </a>
                        <div class="product-content">
                            <h2 class="product-title">
                                <a href="{{ route('frontend.page', ['taxonomy' => $alias]) }}">
                                    {{ $title }}
                                </a>
                            </h2>
                            <div class="rating small">
                                <div class="star star-{{$item->rating??0}}"></div>
                            </div>
                            <span class="price">
                                @if ($price_old > 0 && $price > 0)
                                    <del aria-hidden="true"><span>{{ '$' . $price_old }}</span></del>
                                    <ins><span>{{ '$' . $price ?? 'Chưa cập nhật' }}</span></ins>
                                @else
                                    {{ '$' . $price ?? 'Chưa cập nhật' }}
                                @endif
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endisset
