{{-- Get menu id in component $component->json_params->menu_id --}}
@php
    $params['status'] = App\Consts::STATUS['active'];
    $params['is_featured'] = true;
    $params['is_type'] = App\Consts::TAXONOMY['post'];
    $rows_post = App\Models\CmsPost::getsqlCmsPost($params)
        ->limit(3)
        ->get();
@endphp

<nav class="header-nav">
    @isset($menu)
        @php
            $menu_childs = $menu->filter(function ($item, $key) use ($component) {
                return $item->parent_id == $component->json_params->menu_id;
            });
        @endphp

        @isset($menu_childs)
            <ul class="header-nav-list">
                @foreach ($menu_childs as $val_menu1)
                    @php
                        $menu_childs_0 = $menu->filter(function ($item, $key) use ($val_menu1) {
                            return $item->parent_id == $val_menu1->id;
                        });
                        if ($loop->index >= ceil(count($menu_childs) / 2)) {
                            continue;
                        }
                    @endphp
                    <li class="header-nav-item">
                        <a href="{{ $val_menu1->url_link }}"
                            title="{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}"
                            class="{{ $val_menu1->json_params->style == 'header-nav-button' ? $val_menu1->json_params->style : 'header-nav-item-link' }}">{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}</a>
                        @if (isset($menu_childs_0) && count($menu_childs_0) > 0)
                            <div class="mega-menu position-absolute">
                                <div class="container">
                                    <div class="mega-menu-main d-flex">
                                        <div class="mega-menu-list d-flex">
                                            @foreach ($menu_childs_0 as $val_menu2)
                                                @php
                                                    $menu_childs_1 = $menu->filter(function ($item, $key) use ($val_menu2) {
                                                        return $item->parent_id == $val_menu2->id;
                                                    });
                                                    if ($val_menu2->json_params->style == 'image') {
                                                        continue;
                                                    }
                                                @endphp
                                                <div class="mega-menu-col">
                                                    <a href="{{ $val_menu2->url_link }}"
                                                        class="mega-menu-col-title">{{ $val_menu2->json_params->name->$locale ?? $val_menu2->name }}</a>
                                                    @if (isset($menu_childs_1) && count($menu_childs_1) > 0)
                                                        <ul class="mega-menu-list">
                                                            @foreach ($menu_childs_1 as $val_menu3)
                                                                <li>
                                                                    <a href="{{ $val_menu3->url_link }}"
                                                                        class="mega-menu-list-item">{{ $val_menu3->json_params->name->$locale ?? $val_menu3->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        @php
                                            $menu_image = $menu_childs_0->first(function ($item, $key) {
                                                return ($item->json_params->style == 'image');
                                            });
                                        @endphp
                                        @if (isset($menu_image))
                                            <div class="mega-menu-side">
                                                <div class="mega-menu-image">
                                                    <img src="{{$menu_image->json_params->image}}" alt="{{$menu_image->name}}" />
                                                </div>
                                                <a href="{{$menu_image->url_link}}" title="{{$menu_image->name}}"><span>{{$menu_image->name}}</span><svg width="16"
                                                        height="8" viewBox="0 0 16 8" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_48_13374)">
                                                            <path
                                                                d="M11.937 7.99984C11.6858 7.88884 11.5797 7.75851 11.6323 7.56738C11.6617 7.46044 11.7406 7.35661 11.8217 7.27523C12.547 6.54688 13.2775 5.82383 14.0069 5.09954C14.2426 4.86569 14.4797 4.63309 14.7546 4.36183H14.5239C9.936 4.36183 5.34847 4.36183 0.760624 4.36183C0.641004 4.36183 0.52107 4.36557 0.40145 4.3609C0.16127 4.35092 -0.000624474 4.20032 1.81067e-06 3.99392C0.000628095 3.79437 0.155007 3.6472 0.387672 3.62787C0.43934 3.62351 0.491635 3.62631 0.54393 3.62631C5.19941 3.62631 9.8549 3.62631 14.5101 3.62631H14.7387C14.672 3.55585 14.6319 3.51095 14.5893 3.46886C13.6546 2.53878 12.7198 1.60901 11.7851 0.678615C11.6004 0.494969 11.5703 0.30571 11.6962 0.14233C11.8183 -0.016061 12.0328 -0.0472403 12.1934 0.0728002C12.2432 0.109904 12.289 0.152931 12.3331 0.196582C13.4936 1.34866 14.6541 2.50074 15.8124 3.655C15.8848 3.72702 15.938 3.81775 16 3.89975V4.08621C15.9264 4.17912 15.8616 4.28045 15.7783 4.3637C14.6422 5.49676 13.5046 6.62795 12.3635 7.75602C12.2667 7.85143 12.1424 7.91909 12.0309 7.99953H11.9373L11.937 7.99984Z"
                                                                fill="black" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_48_13374">
                                                                <rect width="16" height="8" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            <ul class="header-nav-list">
                @foreach ($menu_childs as $val_menu1)
                    @php
                        $menu_childs_0 = $menu->filter(function ($item, $key) use ($val_menu1) {
                            return $item->parent_id == $val_menu1->id;
                        });
                        if ($loop->index < ceil(count($menu_childs) / 2)) {
                            continue;
                        }
                    @endphp
                    <li class="header-nav-item">
                        <a href="{{ $val_menu1->url_link }}"
                            title="{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}"
                            class="{{ $val_menu1->json_params->style == 'header-nav-button' ? $val_menu1->json_params->style : 'header-nav-item-link' }}">{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}</a>
                    </li>
                @endforeach
            </ul>
        @endisset
    @endisset



    <div class="d-block d-xl-none d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#menu-mobile"
        aria-controls="menu-mobile">
        <svg height="24" viewBox="0 0 16 16" width="24" xmlns="http://www.w3.org/2000/svg" fill="#ffffff">
            <g id="_31" data-name="31">
                <path d="m15.5 4h-15a.5.5 0 0 1 0-1h15a.5.5 0 0 1 0 1z" />
                <path d="m15.5 9h-15a.5.5 0 0 1 0-1h15a.5.5 0 0 1 0 1z" />
                <path d="m15.5 14h-15a.5.5 0 0 1 0-1h15a.5.5 0 0 1 0 1z" />
            </g>
        </svg>
    </div>
</nav>

{{-- @isset($menu)
    @php
        $menu_childs = $menu->filter(function ($item, $key) use ($component) {
            return $item->parent_id == $component->json_params->menu_id;
        });
    @endphp
    @isset($menu_childs)
        @foreach ($menu_childs as $val_menu1)
            @php
                $menu_childs_0 = $menu->filter(function ($item, $key) use ($val_menu1) {
                    return $item->parent_id == $val_menu1->id;
                });
            @endphp
            @if (isset($val_menu1->json_params->style) && $val_menu1->json_params->style == 'mega-menu')
                <li
                    class="level-0 menu-item {{ count($menu_childs_0) > 0 ? 'menu-item-has-children' : '' }} mega-menu current-menu-item">
                    <a href="{{ $val_menu1->url_link }}"><span
                            class="menu-item-text">{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}</span></a>
                    <div class="sub-menu">
                        <div class="row">
                            @foreach ($menu_childs_0 as $val_menu2)
                                @php
                                    $menu_childs1 = $menu->filter(function ($item, $key) use ($val_menu2) {
                                        return $item->parent_id == $val_menu2->id;
                                    });
                                @endphp
                                <div class="col-md-6">
                                    <div class="menu-section">
                                        <h2 class="sub-menu-title">
                                            {{ $val_menu2->json_params->name->$locale ?? $val_menu2->name }}</h2>
                                        <ul class="menu-list">
                                            @foreach ($menu_childs1 as $val_menu3)
                                                <li>
                                                    <a href="{{ $val_menu3->url_link }}"><span
                                                            class="menu-item-text">{{ $val_menu3->json_params->name->$locale ?? $val_menu3->name }}</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
            @elseif (isset($val_menu1->json_params->style) && $val_menu1->json_params->style == 'mega-menu-fullwidth')
                <li
                    class="level-0 menu-item {{ count($menu_childs_0) > 0 ? 'menu-item-has-children' : '' }} mega-menu mega-menu-fullwidth align-center">
                    <a href="{{ $val_menu1->url_link }}"><span
                            class="menu-item-text">{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}</span></a>
                    <div class="sub-menu">
                        <div class="row">

                            @if (count($menu_childs_0) > 0)
                                <div class="col-md-5">
                                    @foreach ($menu_childs_0 as $val_menu2)
                                        @php
                                            $menu_childs1 = $menu->filter(function ($item, $key) use ($val_menu2) {
                                                return $item->parent_id == $val_menu2->id;
                                            });
                                        @endphp
                                        <div class="menu-section">
                                            <h2 class="sub-menu-title">
                                                {{ $val_menu2->json_params->name->$locale ?? $val_menu2->name }}
                                            </h2>
                                            @if (count($menu_childs1) > 0)
                                                <ul class="menu-list">
                                                    @foreach ($menu_childs1 as $val_menu3)
                                                        <li>
                                                            <a href="{{ $val_menu3->url_link }}"><span
                                                                    class="menu-item-text">{{ $val_menu3->json_params->name->$locale ?? $val_menu3->name }}</span></a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if (count($rows_post) > 0)
                                <div class="col-md-7">
                                    <div class="menu-section">
                                        <h2 class="sub-menu-title">@lang('Recent Posts')</h2>
                                        <div class="block block-posts recent-posts p-t-5">
                                            <ul class="posts-list">
                                                @foreach ($rows_post as $val)
                                                    <li class="post-item">
                                                        <a href="{{ route('frontend.page', ['taxonomy' => $val->alias ?? '']) }}"
                                                            class="post-image">
                                                            <img src="{{ $val->image }}">
                                                        </a>
                                                        <div class="post-content">
                                                            <h2 class="post-title">
                                                                <a
                                                                    href="{{ route('frontend.page', ['taxonomy' => $val->alias ?? '']) }}">
                                                                    {{ $val->json_params->name->$locale ?? $val->name }}
                                                                </a>
                                                            </h2>
                                                            <div class="post-time">
                                                                <span
                                                                    class="post-date">{{ date('M d, Y', strtotime($val->created_at)) }}</span>
                                                                <span class="post-comment">{{ $val->comment }}
                                                                    @lang('Comments')</span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </li>
            @else
                <li class="level-0 menu-item {{ count($menu_childs_0) > 0 ? 'menu-item-has-children' : '' }}">
                    <a href="{{ $val_menu1->url_link }}"><span
                            class="menu-item-text">{{ $val_menu1->json_params->name->$locale ?? $val_menu1->name }}</span></a>

                    @if ($menu_childs_0)
                        <ul class="sub-menu">
                            @foreach ($menu_childs_0 as $val_menu2)
                                @php
                                    $menu_childs1 = $menu->filter(function ($item, $key) use ($val_menu2) {
                                        return $item->parent_id == $val_menu2->id;
                                    });
                                @endphp
                                <li class="{{ count($menu_childs1) > 0 ? 'level-1 menu-item menu-item-has-children' : '' }}">
                                    <a href="{{ $val_menu2->url_link }}"><span
                                            class="menu-item-text">{{ $val_menu2->json_params->name->$locale ?? $val_menu2->name }}</span></a>
                                    @if (count($menu_childs1) > 0)
                                        <ul class="sub-menu">
                                            @foreach ($menu_childs1 as $val_menu3)
                                                <li>
                                                    <a href="{{ $val_menu3->url_link }}"><span
                                                            class="menu-item-text">{{ $val_menu3->json_params->name->$locale ?? $val_menu3->name }}</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </li>
            @endif
        @endforeach


    @endisset
@endisset --}}
