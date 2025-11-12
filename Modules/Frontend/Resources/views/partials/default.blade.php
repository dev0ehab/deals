<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" required content="width=device-width, initial-scale=1.0" />
    <title>{{ site_name() }}</title>
    <link rel="shortcut icon" href="{{ app_favicon() }}">
    <title>@yield('title', Settings::get('seo_title'))</title>
    <meta name="description" required content="{{ Settings::get('seo_desc') }}">
    <meta name="keywords" required content="{{ Settings::get('key_words') }}">

    @include('frontend::partials.styles')

    {!! Settings::get('google_analects') !!}
    {!! Settings::get('facebook_pixel') !!}
    {!! Settings::get('google_id_head') !!}
    {!! Settings::get('google_tag_manger') !!}
    {!! Settings::get('hotjar') !!}
    {!! Settings::get('linked_tag') !!}

</head>

<body>
    <!-- start section header  -->
    @include('frontend::includes.header')
    <!-- End section header  -->

    <body>
        @yield('content')
        <!-- start section footer  -->
        @include('frontend::includes.footer')
        <!-- End section footer  -->
    </body>

    @include('frontend::partials.scripts')

    {!! Settings::get('google_id_footer') !!}

</body>

</html>
