 <header class="site-header header header-creative-one header-sidenav onepage">
     <!-- main header -->
     <div class="sticky-header main-bar-wraper navbar-expand-lg">
         <div class="main-bar clearfix d-flex align-items-center">

             <div class="bulr-bg"></div>
             <!-- website logo -->
             <div class="logo-header mostion logo-dark">
                 <a href="{{ url('/') }}">
                     <img src="{{ app_logo() }}" class="py-3" alt="">
                 </a>
             </div>
             <!-- extra nav -->
             <div class="extra-nav d-flex justify-content-end align-items-center gap-3" style="flex:1;">
                 <div class="pt-1"><a href="{{ Settings::get('facebook') }}" target="blank"><i
                             class="fab fa-facebook-f fs-5"></i></a></div>
                 <div class="pt-1"><a href="{{ Settings::get('twitter') }}" target="blank"><i
                             class="fab fa-twitter fs-5"></i></a></div>
                 <div class="pt-1"><a href="{{ Settings::get('tiktok') }}" target="blank"><i
                             class="fab fa-tiktok fs-5"></i></a></div>
                 <div class="pt-1"><a href="{{ Settings::get('instagram') }}" target="blank"><i
                             class="fab fa-instagram fs-5"></i></a></div>
                 @if (app()->getLocale() == 'ar')
                     <a href="{{ route('frontend.locale', 'en') }}" class="d-flex gap-1">
                         <span class="fs-5 lh-1 pt-1">En</span>
                     @else
                         <a href="{{ route('frontend.locale', 'ar') }}" class="d-flex gap-1">
                             <span class="fs-5 lh-1 pt-1">Ar</span>
                 @endif
                 <svg class="pt-1" fill="none" height="25" width="25" stroke-width="1.5" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                     <path
                         d="M2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12Z"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                     <path d="M13 2.04932C13 2.04932 16 5.99994 16 11.9999C16 17.9999 13 21.9506 13 21.9506"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                     <path d="M11 21.9506C11 21.9506 8 17.9999 8 11.9999C8 5.99994 11 2.04932 11 2.04932"
                         stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                     <path d="M2.62964 15.5H21.3704" stroke="currentColor" stroke-linecap="round"
                         stroke-linejoin="round" />
                     <path d="M2.62964 8.5H21.3704" stroke="currentColor" stroke-linecap="round"
                         stroke-linejoin="round" />
                 </svg>
                 </a>
             </div>
         </div>
         <div class="header-nav navbar-collapse collapse full-sidenav navbar">
             <ul class="nav navbar-nav">
                 <li><a href="#home" class="scroll nav-link">@lang('Home')</a></li>
                 <li><a href="#our-service" class="scroll nav-link">@lang('Our Service')</a></li>
                 <li><a href="#about" class="scroll nav-link">@lang('About Us')</a></li>
                 <li><a href="#client" class="scroll nav-link">@lang('Our Clients')</a></li>
                 <li><a href="#contact_us" class="scroll nav-link">@lang('Contact Us')</a></li>
             </ul>
             <div class="social-menu">
                 <ul>
                     <li><a href="https://www.facebook.com/ {{ Settings::get('facebook') }}" target="blank"><i
                                 class="fab fa-facebook-f"></i></a></li>
                     <li><a href="https://www.twitter.com/ {{ Settings::get('twitter') }}" target="blank"><i
                                 class="fab fa-twitter"></i></a></li>
                     <li><a href="https://www.tiktok.com/ {{ Settings::get('tiktok') }}" target="blank"><i
                                 class="fab fa-tiktok"></i></a></li>
                     <li><a href="https://mail.instagram.com/ {{ Settings::get('instagram') }}" target="blank"><i
                                 class="fab fa-instagram"></i></a></li>
                 </ul>
                 <p class="copyright-head">© 2024 Tawakal </p>
             </div>
         </div>
         <div class="menu-close">
             <i class="ti-close"></i>
         </div>
     </div>
     <!-- main header END -->
 </header>
