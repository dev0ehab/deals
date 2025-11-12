<div class="section-full bg-white content-inner" id="our-service">
    <div class="container">
        <div class="section-head text-center head-style-2 wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
            <h2 class="title">Our Services</h2>
            <div class="dlab-separator-outer">
                <div class="dlab-separator bg-primary"></div>
            </div>
            <p>There are many variations of passages of Lorem Ipsum typesetting industry has been the
                industry's standard dummy text ever since the been when an unknown printer.</p>
        </div>
        <div class="row justify-content-center">

            @forelse ($services as $service)
                <div class="col-lg-4 col-md-6 col-sm-6 wow fadeInUp single-service" data-wow-duration="2s">
                    <div class="icon-bx-wraper center m-b40">
                        <div class="bg-primary m-b20 m-auto p-2 mb-3" style="max-width:max-content;"> <span
                                class="icon-cell">
                                <img class="icon-bx-xs icon-bx-60"
                                    src="{{ $service->cover }}" alt="services ">
                            </span></div>
                        <div class="icon-content">
                            <h5 class="dlab-tilte text-uppercase">{{  $service->name }}</h5>
                            <p>{!!  $service->description !!}</p>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse


        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button type="button" class="site-button show-services my-4">Show More...</button>
            </div>
        </div>
    </div>
</div>
