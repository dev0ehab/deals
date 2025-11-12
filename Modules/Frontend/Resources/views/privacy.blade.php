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
    <link rel="icon" href="{{ asset('frontend/images/new/favicon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/new/favicon.png') }}" />

    <!-- PAGE TITLE HERE -->
    <title>Tawakal</title>

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

        <!-- Content -->
        <div class="page-content">
            <!-- inner page banner -->
            <div class="dlab-bnr-inr overlay-black-middle" style="background-image:url({{ asset('frontend/images/new/video.jpg') }});">
                <div class="container">
                    <div class="dlab-bnr-inr-entry">
                        <h1 class="text-white">privacy</h1>
                    </div>
                </div>
            </div>
            <!-- inner page banner END -->
            <!-- Breadcrumb row -->
            <div class="breadcrumb-row">
                <div class="container">
                    <ul class="list-inline">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>privacy</li>
                    </ul>
                </div>
            </div>
            <!-- Breadcrumb row END -->
            <!-- contact area -->
            <div class="content">
                <!-- About Company -->
                <div class="section-full bg-white text-center content-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-start">
                                    {{ Settings::locale(app()->getLocale())->get('privacy_content') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- About Company END -->
            </div>
        </div>
        <!-- Content END-->

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
