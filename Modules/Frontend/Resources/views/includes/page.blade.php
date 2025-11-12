<div class="section-full about-box content-inner bg-gray" id="{{ $page }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 m-b30 p-r50 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.3s">
                <div class="section-head head-style-2">
                    <h2 class="title"><span class="text-primary">{{ __("settings::settings.tabs.$page") }}</span>
                    </h2>
                    <div class="dlab-separator-outer">
                        <div class="dlab-separator bg-primary"></div>
                    </div>
                    <p>{!! Settings::locale(app()->getLocale())->get("{$page}_content") !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>
