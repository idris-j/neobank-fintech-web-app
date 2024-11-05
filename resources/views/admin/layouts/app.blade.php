<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('page_title') - {{ __(basicControl()->site_title) }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ getFile(basicControl()->favicon_driver, basicControl()->favicon) }}">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-icons.css') }}">
    <link rel="preload" href="{{ asset('assets/admin/css/theme.min.css') }}" data-hs-appearance="default" as="style">
    <link rel="preload" href="{{ asset('assets/admin/css/theme-dark.min.css') }}" data-hs-appearance="dark" as="style">
    @stack('css-lib')

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">

    @stack('css')

    <style data-hs-appearance-onload-styles>
        * {
            transition: unset !important;
        }

        body {
            opacity: 0;
        }
    </style>

    <script>
        window.hs_config = {
            "autopath": "@@autopath",
            "deleteLine": "hs-builder:delete",
            "deleteLine:build": "hs-builder:build-delete",
            "deleteLine:dist": "hs-builder:dist-delete",
            "previewMode": false,
            "startPath": "",
            "vars": {
                "themeFont": "https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap",
                "version": "?v=1.0"
            },
            "layoutBuilder": {
                "extend": {"switcherSupport": true},
                "header": {"layoutMode": "default", "containerMode": "container-fluid"},
                "sidebarLayout": "default"
            },
            "themeAppearance": {
                "layoutSkin": "default",
                "sidebarSkin": "default",
                "styles": {
                    "colors": {
                        "primary": "#377dff",
                        "transparent": "transparent",
                        "white": "#fff",
                        "dark": "132144",
                        "gray": {"100": "#f9fafc", "900": "#1e2022"}
                    }, "font": "Inter"
                }
            },
            "languageDirection": {"lang": "en"},
            "minifyCSSFiles": ["assets/css/theme.css", "assets/css/theme-dark.css"],
            "copyDependencies": {
                "dist": {"*assets/js/theme-custom.js": ""},
                "build": {"*assets/js/theme-custom.js": "", "node_modules/bootstrap-icons/font/*fonts/**": "assets/css"}
            },
            "buildFolder": "",
            "replacePathsToCDN": {},
            "directoryNames": {"src": "./src", "dist": "./dist", "build": "./build"},
            "fileNames": {
                "dist": {"js": "theme.min.js", "css": "theme.min.css"},
                "build": {
                    "css": "theme.min.css",
                    "js": "theme.min.js",
                    "vendorCSS": "vendor.min.css",
                    "vendorJS": "vendor.min.js"
                }
            },
            "fileTypes": "jpg|png|svg|mp4|webm|ogv|json"
        }

    </script>
</head>


<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl footer-offset {{ env('IS_DEMO') == true ? 'demo' : '' }}">


<script src="{{ asset('assets/admin/js/hs.theme-appearance.js') }}"></script>

<script
    src="{{ asset('assets/admin/js/hs-navbar-vertical-aside-mini-cache.js') }}"></script>

@include('admin.layouts.announcement_bar')

@include('admin.layouts.header')

@include('admin.layouts.sidebar')

<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main" class="main">
    <!-- Content -->
    @yield('content')
    <!-- End Content -->
</main>
<!-- ========== END MAIN CONTENT ========== -->
@stack('loadModal')


<script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/hs-form-search.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/hs-navbar-vertical-aside.min.js') }}"></script>

@stack('js-lib')

<!-- JS Global Compulsory  -->
<script src="{{ asset('assets/global/js/notiflix-aio-3.2.6.min.js') }}"></script>
<script src="{{ asset('assets/global/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/global/js/axios.min.js') }}"></script>
<script src="{{ asset('assets/global/js/pusher.min.js') }}"></script>


<script src="{{ asset('assets/admin/js/theme.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/js-switch-element.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/main.js') }}"></script>


<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    (function () {
        // STYLE SWITCHER
        const $dropdownBtn = document.getElementById('selectThemeDropdown') // Dropdown trigger
        const $variants = document.querySelectorAll(`[aria-labelledby="selectThemeDropdown"] [data-icon]`)

        const setActiveStyle = function () {
            $variants.forEach($item => {
                if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                    $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`
                    return $item.classList.add('active')
                }
                $item.classList.remove('active')
            })
        }

        $variants.forEach(function ($item) {
            $item.addEventListener('click', function () {
                var $theme = $item.getAttribute('data-value');
                if ($theme == 'auto') {
                    $('aside').removeClass('navbar-bordered bg-white navbar-vertical-aside-initialized')
                    $('aside').addClass('navbar-dark bg-dark navbar-vertical-aside-initialized')
                } else if ($theme == 'default') {
                    $('aside').removeClass('navbar-dark bg-dark navbar-vertical-aside-initialized')
                    $('aside').addClass('navbar-bordered bg-white navbar-vertical-aside-initialized')
                }
                HSThemeAppearance.setAppearance($theme)

                $.ajax({
                    url: "{{route('admin.themeMode')}}/" + $theme,
                    type: 'get',
                    success: function (response) {
                        if(response != 'dark'){
                            if(response == 'auto'){
                                var $themeImgSource = "{{ getFile($basicControl->admin_dark_mode_logo_driver, $basicControl->admin_dark_mode_logo, true) }}";
                            }else{
                                var $themeImgSource = "{{ getFile($basicControl->admin_logo_driver, $basicControl->admin_logo, true) }}";
                            }
                            var element = document.querySelector('.navbar-brand-logo-auto');
                            if (element) {
                                element.setAttribute('src', $themeImgSource);
                            }
                        }
                    }
                });
            })
        })
        setActiveStyle()
        window.addEventListener('on-hs-appearance-change', function () {
            setActiveStyle()
        })
    })();


</script>

@stack('script')

@auth
    <script>
        'use strict'
        let pushNotificationArea = new Vue({
            el: "#pushNotificationArea",
            data: {
                items: [],
            },
            mounted() {
                this.getNotifications();
                this.pushNewItem();
            },
            methods: {
                getNotifications() {
                    let app = this;
                    axios.get("{{ route('admin.push.notification.show') }}")
                        .then(function (res) {
                            app.items = res.data;
                        })
                },
                readAt(id, link) {
                    let app = this;
                    let url = "{{ route('admin.push.notification.readAt', 0) }}";
                    url = url.replace(/.$/, id);
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.getNotifications();
                                if (link !== '#') {
                                    window.location.href = link
                                }
                            }
                        })
                },
                readAll() {
                    let app = this;
                    let url = "{{ route('admin.push.notification.readAll') }}";
                    axios.get(url)
                        .then(function (res) {
                            if (res.status) {
                                app.items = [];
                            }
                        })
                },
                pushNewItem() {
                    let app = this;
                    Pusher.logToConsole = false;
                    let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                        encrypted: true,
                        cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                    });
                    let channel = pusher.subscribe('admin-notification.' + "{{ Auth::id() }}");
                    channel.bind('App\\Events\\AdminNotification', function (data) {
                        app.items.unshift(data.message);
                    });
                    channel.bind('App\\Events\\UpdateAdminNotification', function (data) {
                        app.getNotifications();
                    });
                }
            }
        });
    </script>
@endauth

@include('partials.notify')

</body>
</html>




