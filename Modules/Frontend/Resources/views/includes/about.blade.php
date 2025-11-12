<div class="section-full about-box content-inner bg-gray" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 m-b30 p-r50 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.3s">
                <div class="section-head head-style-2">
                    <h2 class="title"><span class="text-primary">{{ Settings::locale(app()->getLocale())->get('about_title') }}</span></h2>
                    <div class="dlab-separator-outer">
                        <div class="dlab-separator bg-primary"></div>
                    </div>
                    <p>{!! Settings::locale(app()->getLocale())->get('about_description') !!}</p>
                </div>
                <a href="#" class="site-button button-md radius-no">@lang('GET A QUOTE')</a>
            </div>
            <div class="col-lg-6 m-b30 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.6s">
                <div class="video-box">
                    <img src="{{ asset('frontend/images/new/video.jpg') }}" alt="">
                    <div class="video-play">
                        <a href="{{ asset('frontend/images/intro.mp4') }}"
                            class="popup-youtube gradient-shadow bg-gradient video"><i class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
