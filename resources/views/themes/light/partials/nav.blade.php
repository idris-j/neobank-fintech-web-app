<nav class="navbar fixed-top navbar-expand-lg header-upper">
    <div class="container">
        <a class="navbar-brand logo" href="https://jeemo.io">
            <img id="sitelogo" src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="...">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" style="background: none; border: none; padding: 0;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Top line (full width) -->
        <rect y="4" width="24" height="2" fill="currentColor" />
        <!-- Middle line (shorter on the right side) -->
        <rect y="11" width="18" height="2" fill="currentColor" />
        <!-- Bottom line (full width) -->
        <rect y="18" width="24" height="2" fill="currentColor" />
    </svg>
</button>


        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbar">
            <div class="offcanvas-header">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo" src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="...">
                </a>
                <button type="button" class="cmn-btn-close btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"><i class="fa-light fa-arrow-right"></i></button>
            </div>
            <div class="offcanvas-body align-items-center justify-content-between">
                <ul class="navbar-nav ms-auto">
                    <li style="list-style: none; margin: 0; padding: 0; display: inline;"> <!-- Inline CSS to remove dot -->
                        @guest
                            <a class="login-btn scrollto" href="{{ route('login') }}" title="@lang('Login')">
                                <i class="fa-solid fa-right-to-bracket"></i>{{ trans('Login') }}
                            </a>
                        @else
                            <a class="get-start-btn" href="{{ route('user.dashboard') }}">{{ trans('Dashboard') }}</a>
                        @endguest
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>


<!-- Bottom Mobile Tab nav section start -->
{{-- <ul class="nav bottom-nav fixed-bottom d-lg-none">
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasNavbar"
           href="#offcanvasNavbar" aria-current="page"><i class="fa-light fa-list"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link @active('blog')" href="{{ route('blog') }}" title="@lang('Explore our Blogs')">
            <i class="fa-light fa-planet-ringed"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->is('/')) active @endif" href="{{ url('/') }}" title="@lang('Home')">
            <i class="fa-light fa-house"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link  @if(request()->is('contact')) active @endif" href="{{ url('/contact') }}" title="@lang('Contact')">
            <i class="fa-light fa-address-book"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link @active('user.profile')" href="{{ route('user.profile') }}" title="@lang('Profile')">
            <i class="fa-light fa-user"></i></a>
    </li>
</ul>



<!-- Bottom Mobile Tab nav section start -->
<ul class="nav bottom-nav fixed-bottom d-lg-none">
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" role="button" aria-controls="offcanvasNavbar"
           href="#offcanvasNavbar" aria-current="page"><i class="fa-light fa-list"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link @active('blog')" href="{{ route('blog') }}" title="@lang('Explore our Blogs')">
            <i class="fa-light fa-planet-ringed"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link @if(request()->is('/')) active @endif" href="{{ url('/') }}" title="@lang('Home')">
            <i class="fa-light fa-house"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link  @if(request()->is('contact')) active @endif" href="{{ url('/contact') }}" title="@lang('Contact')">
            <i class="fa-light fa-address-book"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link @active('user.profile')" href="{{ route('user.profile') }}" title="@lang('Profile')">
            <i class="fa-light fa-user"></i></a>
    </li>
</ul> --}}
