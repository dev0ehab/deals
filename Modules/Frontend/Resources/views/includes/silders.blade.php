<div class="creative-banner-one" style="padding-top: 8rem !important" id="home">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @forelse ($services as $service)
                <div class="swiper-slide">
                    <div class="vehicle-box style1"

                        style="background-image: url({{ $service->cover }}); width:800px; height:75%">

                        <div class="left-info px-lg-6 justify-content-center" data-name="">
                            <div class="top-info">
                              <h2 class="title" data-swiper-parallax="-500">{{ $service->name }}</h2>
                                {{-- <h3 class="main-title" data-swiper-parallax="-400">{{ $service->sub_title }}</h3> --}}
                            </div>
                            <div class="bottom-info">
                                <div class="bg-primary ">
                                    {{-- <h3 data-swiper-parallax="-300">70km</h3>
                                    <h3 data-swiper-parallax="-200">extended urban range</h3>
                                    <h3 data-swiper-parallax="-100">lithium-ion revolution</h3> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

        </div>
        <div class="bottom-aside">
            <!-- Add Arrows -->
            <div class="swiper-button-arrow">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>
