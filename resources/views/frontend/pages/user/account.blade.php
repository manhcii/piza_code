<!DOCTYPE html>
<html lang="{{ $locale ?? 'vi' }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ $page->json_params->name->$locale ?? ($page->name ?? ($page->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')))) }}
    </title>
    <link rel="icon" href="{{ json_decode($setting->image)->favicon ?? '' }}" type="image/x-icon">
    {{-- Print SEO --}}
    @php
        $seo_title = $seo_title ?? ($page->json_params->seo_title->$locale ?? ($setting->{$locale . '-seo_title'} ?? ($setting->seo_title ?? '')));
        $seo_keyword = $seo_keyword ?? ($page->json_params->seo_keyword->$locale ?? ($setting->{$locale . '-seo_keyword'} ?? ($setting->seo_keyword ?? '')));
        $seo_description = $seo_description ?? ($page->json_params->seo_description->$locale ?? ($setting->{$locale . '-seo_description'} ?? ($setting->seo_description ?? '')));
        $seo_image = $seo_image ?? ($page->json_params->image ?? (json_decode($setting->image)->seo_og_image ?? ''));
    @endphp
    <meta name="description" content="{{ $seo_description }}" />
    <meta name="keywords" content="{{ $seo_keyword }}" />
    <meta name="news_keywords" content="{{ $seo_keyword }}" />
    <meta property="og:image" content="{{ $seo_image }}" />
    <meta property="og:title" content="{{ $seo_title }}" />
    <meta property="og:description" content="{{ $seo_description }}" />
    <meta property="og:url" content="{{ Request::fullUrl() }}" />
    {{-- End Print SEO --}}
    {{-- Include style for app --}}
    @include('frontend.panels.styles')
    {{-- Styles custom each page --}}
    @stack('style')
</head>

<body class="page">
    <div id="page" class="hfeed page-wrapper">

        @isset($widget->header)
            @if (\View::exists('frontend.widgets.header.' . $widget->header->json_params->layout))
                @include('frontend.widgets.header.' . $widget->header->json_params->layout)
            @else
                {{ 'View: frontend.widgets.header.' . $widget->header->json_params->layout . ' do not exists!' }}
            @endif
        @endisset

        <div id="site-main" class="site-main">
            <div id="main-content" class="main-content">
                <div id="primary" class="content-area">
                    <div id="title" class="page-title">
                        <div class="section-container">
                            <div class="content-title-heading">
                                <h1 class="text-title-heading">
                                    My Account
                                </h1>
                            </div>
                            <div class="breadcrumbs">
                                <a href="index.html">Home</a><span class="delimiter"></span>My Account
                            </div>
                        </div>
                    </div>

                    <div id="content" class="site-content" role="main">
                        <div class="section-padding">
                            <div class="section-container p-l-r">
                                <div class="page-my-account">
                                    <div class="my-account-wrap clearfix">
                                        <nav class="my-account-navigation">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#dashboard"
                                                        role="tab">Dashboard</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#orders"
                                                        role="tab">Orders</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#addresses"
                                                        role="tab">Addresses</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#account-details"
                                                        role="tab">Account details</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('frontend.logout') }}">Logout</a>
                                                </li>
                                            </ul>
                                        </nav>
                                        <div class="my-account-content tab-content">
                                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                                                <div class="my-account-dashboard">
                                                    <p>
                                                        Hello <strong>{{ $user_auth->name }}</strong> (not
                                                        <strong>{{ $user_auth->name }}</strong>? <a
                                                            href="{{ route('frontend.logout') }}">Log out</a>)
                                                    </p>
                                                    <p>
                                                        From your account dashboard you can view your <a
                                                            href="#">recent orders</a>, manage your <a
                                                            href="#">shipping and billing addresses</a>, and <a
                                                            href="#">edit your password and account details</a>.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header ">
                                                            <h3 class="modal-title text-center col-md-12"
                                                                id="exampleModalLabel">Details Order</h3>

                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST">
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Product</th>
                                                                            <th>Name</th>
                                                                            <th>Price</th>
                                                                            <th>Quantity</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="show_order_detail">

                                                                    </tbody>
                                                                </table>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="orders" role="tabpanel">
                                                <div class="my-account-orders">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Total</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($list_order as $val)
                                                                    <tr>
                                                                        <td>#{{ $val->id }}</td>
                                                                        <td>{{ date_format($val->created_at, 'F d, Y') }}
                                                                        </td>
                                                                        <td>{{ App\Consts::ORDER_STATUS[$val->status] }}
                                                                        </td>
                                                                        <td>${{ $val->total }}</td>
                                                                        <td><a href="#" data-toggle="modal"
                                                                                data-id="{{ $val->id }}"
                                                                                data-target="#exampleModal"
                                                                                class="btn-small d-block view_details_order">View</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="addresses" role="tabpanel">
                                                <div class="my-account-addresses">
                                                    <p>
                                                        The following addresses will be used on the checkout page by
                                                        default.
                                                    </p>
                                                    <div class="addresses">
                                                        <div class="addresses-col">
                                                            <header class="col-title">
                                                                <h3>Address</h3>
                                                            </header>
                                                            <div class="form-group">
                                                                <label for="account_first_name">Name <span
                                                                        class="required">*</span></label>
                                                                <input type="text" class="input-text form-control"
                                                                    name="name" value="{{ $user_auth->name }}">
                                                            </div>
                                                            {{-- <address>
                                                            {{ $user_contry->name??"" }}<br>
                                                            {{ $user_city->name??""}},<br>
                                                            {{ $user_auth->street_address??"" }},<br>
                                                            {{ $user_auth->phone??"" }}<br>

                                                        </address> --}}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="account-details" role="tabpanel">
                                                <div class="my-account-account-details">
                                                    <form class="edit-account"
                                                        action="{{ route('frontend.change_account') }}"
                                                        method="post">
                                                        @csrf
                                                        <p class="form-row">
                                                            <label for="account_first_name">Name <span
                                                                    class="required">*</span></label>
                                                            <input type="text" class="input-text" name="name"
                                                                value="{{ $user_auth->name }}">
                                                        </p>

                                                        <div class="clear"></div>
                                                        <p class="form-row">
                                                            <label>Email address <span
                                                                    class="required">*</span></label>
                                                            <input type="email" class="input-text" name="email"
                                                                value="{{ $user_auth->email }}">
                                                        </p>
                                                        <fieldset>
                                                            <legend>Password change</legend>
                                                            <p class="form-row">
                                                                <label>Current password (leave blank to leave
                                                                    unchanged)</label>
                                                                <input type="password" class="input-text"
                                                                    name="password_old" autocomplete="off"
                                                                    value="">
                                                            </p>
                                                            <p class="form-row">
                                                                <label>New password (leave blank to leave
                                                                    unchanged)</label>
                                                                <input type="password" class="input-text"
                                                                    name="password">
                                                            </p>
                                                            <p class="form-row">
                                                                <label>Confirm new password</label>
                                                                <input type="password" class="input-text"
                                                                    name="password_confirmation" autocomplete="off">
                                                            </p>
                                                        </fieldset>
                                                        <div class="clear"></div>
                                                        <p class="form-row">
                                                            <button type="submit" class="button">Save
                                                                changes</button>
                                                        </p>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- #content -->
                </div><!-- #primary -->
            </div><!-- #main-content -->
        </div>

        @isset($widget->footer)
            @if (\View::exists('frontend.widgets.footer.' . $widget->footer->json_params->layout))
                @include('frontend.widgets.footer.' . $widget->footer->json_params->layout)
            @else
                {{ 'View: frontend.widgets.footer.' . $widget->footer->json_params->layout . ' do not exists!' }}
            @endif
        @endisset
    </div>
    {{-- Include scripts --}}
    @include('frontend.panels.scripts')
    @include('frontend.components.sticky.alert')

    {{-- Scripts custom each page --}}
    @stack('script')

</body>

</html>
