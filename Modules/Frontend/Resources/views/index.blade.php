<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- seo -->
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="description"
        content="AutoCare is well designed creating websites of automotive repair shops, stores with spare parts and accessories for car repairs, car washes, car danting and panting, service stations, car showrooms painting, major auto centers and other sites related to cars and car services." />
    <meta property="og:title" content="Auto Care - Car Services Template" />
    <meta property="og:description"
        content="AutoCare is well designed creating websites of automotive repair shops, stores with spare parts and accessories for car repairs, car washes, car danting and panting, service stations, car showrooms painting, major auto centers and other sites related to cars and car services." />
    <meta property="og:image" content="http://autocare.dexignlab.com/xhtml/social-image.png" />
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON -->
    <link rel="icon" href="{{ app_logo() }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ app_logo() }}" />

    <!-- PAGE TITLE HERE -->
    <title>{{ app_name() }}</title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- STYLESHEETS -->
    @include('frontend::partials.styles')

</head>

<body id="bg">
    <div id="loading-area"></div>
    <div class="page-wraper creative-wraper-one">
        <!-- Header -->
        @include('frontend::includes.header')
        <!-- Header END -->

        <!-- Aside Header -->
        @include('frontend::includes.aside')
        <!-- Aside Header -->

        <!-- Content -->
        <div class="page-content bg-white">
            <!-- Slider Carousel -->
            @include('frontend::includes.silders')
            <!-- Slider END -->

            <!-- OUR SERVICES -->
            @include('frontend::includes.services')
            <!-- OUR SERVICES END-->

            <!-- About US -->
            {{-- @include('frontend::includes.about') --}}
            <!-- About US End -->

            @include('frontend::includes.page' , [ 'page' => 'privacy'])
            @include('frontend::includes.page' , [ 'page' => 'terms'])
            @include('frontend::includes.page' , [ 'page' => 'aboutus'])

            <!-- What peolpe are saying style 3 -->
            @include('frontend::includes.people')
            <!-- What peolpe are saying style 3 END -->

            <!-- Contact Us -->
            @include('frontend::includes.contact')
            <!-- Contact Us End -->

        </div>
        <!-- Footer -->
        @include('frontend::includes.footer')
        <!-- Footer END-->
        <!-- scroll top button -->
        <button class="scroltop fas fa-arrow-up style1"></button>
    </div>
    <!-- JavaScript  files ========================================= -->
    @include('frontend::partials.scripts')
</body>

</html>
