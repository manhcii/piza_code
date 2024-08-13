@php
  $component_setting = $widget->sidebar->json_params->component ?? [];
  // Filter selected
  $components_selected = $components->filter(function ($item) use ($component_setting) {
      return in_array($item->id, $component_setting);
  });
  // Reorder selected
  $components_selected = $components_selected->sortBy(function ($item) use ($component_setting) {
      return array_search($item->id, $component_setting);
  });
@endphp


{{-- Get all component, order and show by component_code --}}
@if (isset($components_selected))
    @foreach ($components_selected as $component)
        @if (\View::exists('frontend.components.' . $widget->sidebar->json_params->layout . '.' . $component->component_code. '.index'))
            @include('frontend.components.' . $widget->sidebar->json_params->layout . '.' . $component->component_code. '.index')
        @else
            {{ 'View: frontend.components.' . $widget->sidebar->json_params->layout . '.' . $component->component_code . '.index do not exists!' }}
        @endif
    @endforeach
@endif
