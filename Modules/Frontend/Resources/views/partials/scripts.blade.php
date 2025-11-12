<script src="{{ asset('frontend/js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
<script src="{{ asset('frontend/plugins/wow/wow.js') }}"></script><!-- WOW JS -->
<script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ asset('frontend/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
<script src="{{ asset('frontend/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script><!-- FORM JS -->
<script src="{{ asset('frontend/plugins/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
<script src="{{ asset('frontend/plugins/counter/waypoints-min.js') }}"></script><!-- WAYPOINTS JS -->
<script src="{{ asset('frontend/plugins/counter/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
<script src="{{ asset('frontend/plugins/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED -->
<script src="{{ asset('frontend/plugins/masonry/masonry-3.1.4.js') }}"></script><!-- MASONRY -->
<script src="{{ asset('frontend/plugins/masonry/masonry.filter.js') }}"></script><!-- MASONRY -->
<script src="{{ asset('frontend/plugins/owl-carousel/owl.carousel.js') }}"></script><!-- OWL SLIDER -->
<script src="{{ asset('frontend/plugins/rangeslider/rangeslider.js') }}"></script><!-- Rangeslider -->
<script src="{{ asset('frontend/plugins/lightgallery/js/lightgallery-all.js') }}"></script><!-- LIGHT GALLERY -->
<script src="{{ asset('frontend/js/custom.min.js') }}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{ asset('frontend/js/dz.carousel.min.js') }}"></script><!-- SORTCODE FUCTIONS  -->
<script src="{{ asset('frontend/js/dz.ajax.js') }}"></script><!-- CONTACT JS -->

<script src="{{ asset('frontend/js/swiper.js') }}"></script>

<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 0,
        speed: 2000,
        autoplay: true,
        parallax: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // show more services
    showMoreBtn = document.querySelector('.show-services')
    services = document.querySelectorAll('.single-service')

    const servicesStatus = (status = 'hide') => {
        services?.length < 7 && showMoreBtn?.classList.add('d-none')
        services?.forEach((service, i) => {
            if (i > 5 && status == 'hide') service.classList.add('d-none')
            else {
                service.classList.remove('d-none')
                service.classList.add('d-block')
            }
        });
    }
    servicesStatus()

    showMoreBtn?.addEventListener('click', e => {
        e.target.classList.add('d-none')
        servicesStatus('show')
    })
</script>
