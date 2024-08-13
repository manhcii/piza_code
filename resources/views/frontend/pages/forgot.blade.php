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
                            Forgot Password
                        </h1>
                    </div>
                </div>
            </div>
            <div id="content" class="site-content" role="main">
                <div class="section-padding">
                    <div class="section-container p-l-r">
                        <div class="page-forget-password">
                            <form method="post" action="{{ route('frontend.password.reset.post') }}" class="reset-password">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <p class="form-row form-row-first">
                                    <label>Email</label>
                                    <input class="input-text" value="{{ old('email') }}" type="email" name="email" autocomplete="username" required>
                                </p>
                                <p class="form-row form-row-first">
                                    <label>New password</label>
                                    <input class="input-text" type="password" name="password" required value="{{ old('password') }}">
                                </p>
                                <p class="form-row form-row-first">
                                    <label>Confirm password</label>
                                    <input class="input-text" type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                </p>
                                <div class="clear"></div>
                                <p class="form-row">
                                    <button type="submit" class="button" value="Reset password">Change password</button>
                                </p>
                            </form>
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
