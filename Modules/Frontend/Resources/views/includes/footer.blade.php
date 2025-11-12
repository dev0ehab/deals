<footer class="site-footer footer-white" id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4 wow fadeInUp" data-wow-duration="2s"
                    data-wow-delay="0.2s">
                    <div class="widget widget_about">
                        <div class="logo-footer"><img src="{{ app_logo() }}" alt="">
                        </div>
                        <p>{!! Settings::locale(app()->getLocale())->get('footer_description') !!}</p>
                        <ul class="dlab-social-icon dlab-border">
                            <li>
                                <a class="fab fa-facebook-f" href="{{ Settings::get('facebook') }}" target="blank"></a>
                            </li>
                            <li>
                                <a class="fab fa-twitter" href="{{ Settings::get('twitter') }}" target="blank"></a>
                            </li>
                            <li>
                                <a class="fab fa-tiktok" href="{{ Settings::get('tiktok') }}" target="blank"></a>
                            </li>
                            <li>
                                <a class="fab fa-instagram" href="{{ Settings::get('instagram') }}" target="blank"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4 wow fadeInUp" data-wow-duration="2s"
                    data-wow-delay="0.4s">
                    <div class="widget recent-posts-entry widget_services">
                        <h4 class="m-b15 text-uppercase">@lang('Links')</h4>
                        <div class="dlab-separator-outer m-b10">
                            <div class="dlab-separator bg-primary"></div>
                        </div>
                        <ul class="section-links d-flex flex-column">
                            <li><a href="#our-service">@lang('Services')</a></li>
                            <li><a href="#aboutus">@lang('About Us')</a></li>
                            <li><a href="#privacy">@lang('settings::settings.tabs.privacy')</a></li>
                            <li><a href="#terms">@lang('settings::settings.tabs.terms')</a></li>
                            <li><a href="#client">@lang('People\'s opinions')</a></li>
                            <li><a href="#contact_us">@lang('Contact Us')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4 wow fadeInUp" data-wow-duration="2s"
                    data-wow-delay="0.6s">
                    <div class="widget widget_services">
                        <h4 class="m-b15 text-uppercase">@lang('Our Services')</h4>
                        <div class="dlab-separator-outer m-b10">
                            <div class="dlab-separator bg-primary"></div>
                        </div>
                        <ul>
                            @forelse ($services as $service)
                                <li><a href="">{{ $service->name }}</a></li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 footer-col-4 wow fadeInUp" data-wow-duration="2s"
                    data-wow-delay="0.8s">
                    <div class="widget widget_getintuch">
                        <h4 class="m-b15 text-uppercase">@lang('Contact Us')</h4>
                        <div class="dlab-separator-outer m-b10">
                            <div class="dlab-separator bg-primary"></div>
                        </div>
                        <ul>
                            <li><i class="ti-location-pin"></i>
                                <strong>@lang('Address')</strong>
                                {{ Settings::get('address') }}
                            </li>
                            <li><i class="ti-mobile"></i>
                                <strong>@lang('Phone')</strong>
                                {{ Settings::get('phone') }}
                            </li>
                            <li><i class="ti-email"></i>
                                <strong>@lang('Email')</strong>
                                {{ Settings::get('email') }}
                            </li>
                            <li class="px-0">
                                <div class="app-download d-flex gap-2">
                                    <a href="/" target="blank" class="d-block">
                                        <img src="{{ asset('frontend/images/new/app-store.png') }}"
                                            alt="app store icon">
                                    </a>
                                    <a href="/" target="blank" class="d-block">
                                        <img src="{{ asset('frontend/images/new/google-play.png') }}"
                                            alt="google play icon">
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer bottom part -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    {{ __('settings::settings.attributes.copyrights') . ' ' . app_name() }}
                    {{ \Carbon\Carbon::now()->year }}
                </div>
            </div>
        </div>
    </div>
</footer>
