@isset($taxonomys)
    <div class="block block-product-cats">
    <div class="block-title">
        <h2>{{$component->title}}</h2>
    </div>
    <div class="block-content">
        <div class="product-cats-list">
            <ul>
                @foreach ($taxonomys as $item)
                <li class="current">
                    <a href="{{route('frontend.page', ['taxonomy' => App\Consts::ROUTE_TAXONOMY['product'], 'alias' => $item->alias ?? ''])}}">{{$item->json_params->name->$locale??$item->name}} <span
                            class="count">{{$item->count_post}}</span></a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endisset
