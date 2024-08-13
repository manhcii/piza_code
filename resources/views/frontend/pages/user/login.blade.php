<!DOCTYPE html>
<html lang="{{ $locale ?? 'vi' }}">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    {{ $seo_title ?? ($page->title ?? ($web_information->information->seo_title ?? '')) }}
  </title>
  <link rel="icon" href="{{ $web_information->image->favicon ?? '' }}" type="image/x-icon">
  {{-- Print SEO --}}
  @php
    $seo_title = $seo_title ?? ($page->title ?? ($web_information->information->seo_title ?? ''));
    $seo_keyword = $seo_keyword ?? ($page->keyword ?? ($web_information->information->seo_keyword ?? ''));
    $seo_description = $seo_description ?? ($page->description ?? ($web_information->information->seo_description ?? ''));
    $seo_image = $seo_image ?? ($page->json_params->og_image ?? ($web_information->image->seo_og_image ?? ''));
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
                            Login / Register
                        </h1>
                    </div>
                </div>
            </div>
            <div id="content" class="site-content" role="main">
                <div class="section-padding">
                    <div class="section-container p-l-r">
                        <div class="page-login-register">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 sm-m-b-50">
                                    <div class="box-form-login">
                                        <h2>Login</h2>
                                        <div class="box-content">
                                            <div class="form-login">
                                                <form method="post" class="login" action="{{route('frontend.login.post')}}">
                                                    @csrf
                                                    <div class="username">
                                                        <label>Username or email address <span class="required">*</span></label>
                                                        <input type="email" class="input-text" required name="email" id="username">
                                                    </div>
                                                    <div class="password">
                                                        <label for="password">Password <span class="required">*</span></label>
                                                        <input class="input-text" required type="password" name="password">
                                                    </div>
                                                    <div class="rememberme-lost">
                                                        <div class="remember-me">
                                                            <input name="rememberme" type="checkbox" value="forever">
                                                            <label class="inline">Remember me</label>
                                                        </div>
                                                        <div class="lost-password">
                                                            <a href="page-forgot-password.html">Lost your password?</a>
                                                        </div>
                                                    </div>
                                                    <div class="button-login">
                                                        <input type="submit" class="button" name="login" value="Login">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="box-form-login">
                                        <h2 class="register">Register</h2>
                                        <div class="box-content">
                                            <div class="form-register">
                                                <form method="post" class="register">
                                                    <div class="email">
                                                        <label>Email address <span class="required">*</span></label>
                                                        <input type="email" class="input-text" name="email" value="">
                                                    </div>
                                                    <div class="password">
                                                        <label>Password <span class="required">*</span></label>
                                                        <input type="password" class="input-text" name="password">
                                                    </div>
                                                    <div class="button-register">
                                                        <input type="submit" class="button" name="register" value="Register">
                                                    </div>
                                                </form>
                                            </div>
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
  {{-- Scripts custom each page --}}
  @include('frontend.components.sticky.alert')

  @stack('script')

</body>

</html>
