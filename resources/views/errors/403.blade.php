<!doctype html>
<html dir="{{ Locales::getDir() }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ app_name() }} | @yield('title', 'DONT HAVE ACCESS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ app_favicon() }}">
    @include('dashboard::layouts.base.head')
</head>

<body data-layout="detached" data-topbar="colored">
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="text-center p-3">
                                <div class="img">
                                    <img src="{{ asset('images/error.png') }}" class="img-fluid" alt="">
                                </div>
                                <h1 class="error-page mt-5"><span>403!</span></h1>
                                <h4 class="mb-4 mt-5">{{ __('YOU DONT NOT HAVE ANY OF THE NECESSARY ACCESS RIGHTS') }}</h4>
                                <a class="btn btn-primary mb-4 waves-effect waves-light" href="{{ route('dashboard.home') }}"><i class="mdi mdi-home"></i> {{ __('Back to Dashboard') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
