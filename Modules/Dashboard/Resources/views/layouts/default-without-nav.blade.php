<!doctype html>
<html dir="{{ Locales::getDir() }}"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <title>{{ app_name() }}
        | @yield('title', $page_title ?? '')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- App favicon -->
    <link rel="shortcut icon"
          href="{{ app_favicon() }}">
    @include('dashboard::layouts.base.head')
</head>
<body>

<div id="vue">
    @yield('content')
</div>

@include('dashboard::layouts.base.footer-script')
</body>
</html>
