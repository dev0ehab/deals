<div class="section-full bg-white bg-img-fix content-inner-1" id="client">
    <div class="container">
        <div class="section-head head-style-2 text-center wow fadeIn" data-wow-duration="2s" data-wow-delay="0.2s">
            <h2 class="title">{{ Settings::locale(app()->getLocale())->get('clients_title') }}</h2>
            <div class="dlab-separator-outer">
                <div class="dlab-separator bg-primary"></div>
            </div>
            <p>{!! Settings::locale(app()->getLocale())->get('clients_description') !!}</p>
        </div>
        <div class="section-content" dir="ltr">
            <div class="testimonial-two owl-carousel owl-theme">
                <div class="item">
                    <div class="testimonial-2 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.2s">
                        <div class="testimonial-text">
                            <p>There are many variations of passages of Lorem Ipsum typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the when
                                an printer took a galley of type and scrambled it to make </p>
                        </div>
                        <div class="testimonial-detail clearfix">
                            <div class="testimonial-pic quote-left radius shadow">
                                <img src="{{ asset('frontend/images/testimonials/pic1.jpg') }}" width="100" height="100" alt="">
                            </div>
                            <strong class="testimonial-name">David Matin</strong> <span
                                class="testimonial-position">Student</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial-2 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.4s">
                        <div class="testimonial-text">
                            <p>There are many variations of passages of Lorem Ipsum typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the when
                                an printer took a galley of type and scrambled it to make </p>
                        </div>
                        <div class="testimonial-detail clearfix">
                            <div class="testimonial-pic quote-left radius shadow">
                                <img src="{{ asset('frontend/images/testimonials/pic2.jpg') }}" width="100" height="100" alt="">
                            </div>
                            <strong class="testimonial-name">Malkovaa Sarena</strong> <span
                                class="testimonial-position">Student</span>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial-2 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.6s">
                        <div class="testimonial-text">
                            <p>There are many variations of passages of Lorem Ipsum typesetting industry.
                                Lorem Ipsum has been the industry's standard dummy text ever since the when
                                an printer took a galley of type and scrambled it to make </p>
                        </div>
                        <div class="testimonial-detail clearfix">
                            <div class="testimonial-pic quote-left radius shadow">
                                <img src="{{ asset('frontend/images/testimonials/pic3.jpg') }}" width="100" height="100" alt="">
                            </div>
                            <strong class="testimonial-name">Disha Davin</strong> <span
                                class="testimonial-position">Student</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
