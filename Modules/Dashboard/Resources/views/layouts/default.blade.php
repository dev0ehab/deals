<!doctype html>
<html dir="{{ Locales::getDir() }}"
      lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <title>{{ app_name() }}
        | @yield('title', $page_title ?? '')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- App favicon -->
    <link rel="shortcut icon"
          href="{{  app_favicon() }}">
    @include('dashboard::layouts.base.head')
</head>

@section('body')
@show
<body data-layout="detached" data-topbar="colored">
@include('dashboard::layouts.base._page-loader')
<!-- Begin page -->
<div class="container-fluid">
    <div id="layout-wrapper">
    @include('dashboard::layouts.base.topbar')
    @include('dashboard::layouts.base.sidebar')
    <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content" id="vue">
                @yield('content')
            </div>
            <!-- End Page-content -->
            @include('dashboard::layouts.base.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->
</div>
<!-- END container-fluid -->


<!-- Right Sidebar -->
{{--@include('dashboard::layouts.base.right-sidebar')--}}
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
@include('dashboard::layouts.base.footer-script')
</body>

</html>
