@if ($component)
  @php
    $layout = isset($component->json_params->layout) && $component->json_params->layout != '' ? $component->json_params->layout : 'default';
  @endphp
@if (\View::exists('frontend.components.' . $widget->sidebar->json_params->layout .'.'.  $component->component_code . '.layout.' . $layout))

    @include('frontend.components.' . $widget->sidebar->json_params->layout .'.'.  $component->component_code . '.layout.' . $layout)
  @else
    {{ 'Style: frontend.components.' . $widget->sidebar->json_params->layout .'.'.  $component->component_code . '.layout.' . $layout . ' do not exists!' }}
  @endif

@endif
