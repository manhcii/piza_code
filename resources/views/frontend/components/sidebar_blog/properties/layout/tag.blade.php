@php
    if (isset($component->json_params->properties_id)) {
        $paramater_id = $component->json_params->properties_id;
        $detail_paramate = $parameter->first(function ($item) use ($paramater_id) {
            return $item->id == $paramater_id;
        });
        if ($detail_paramate) {
            $paramate_childs = $parameter->filter(function ($item) use ($detail_paramate) {
                return $item->parent_id == $detail_paramate->id;
            });
        }
    }
@endphp
@isset($detail_paramate)
    <div class="block block-post-tags">
        <div class="block-title">
            <h2>{{ $detail_paramate->name }}</h2>
        </div>
        <div class="block-content">
            @isset($paramate_childs)
                <div class="post-tags-list">
                    <ul>
                        @foreach ($paramate_childs as $item)
                            <li class="{{(isset($request['tag']) && $request['tag'] == $item->propety_value)?'active':''}}">
                                <span class=" cursor click_input">
                                    <input class="input_hiddent" value="{{ $item->propety_value }}" name="tag" type="radio" {{(isset($request['tag']) && $request['tag'] == $item->propety_value)?'checked':''}}>
                                    <label class="name">{{ $item->name }}</label>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endisset
        </div>
    </div>
@endisset
