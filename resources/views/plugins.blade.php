<!--Start of Google analytic Script-->
@if(basicControl()->analytic_status)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{basicControl()->measurement_id}}"></script>
    <script>
        "use strict";
        var MEASUREMENT_ID = "{{ basicControl()->measurement_id }}";
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', MEASUREMENT_ID);
    </script>
@endif
<!--End of Google analytic Script-->


<!--Start of Tawk.to Script-->
@if(basicControl()->tawk_status)
    <script type="text/javascript">
        // $(document).ready(function () {
        var Tawk_SRC = 'https://embed.tawk.to/' + "{{ trim(basicControl()->tawk_id) }}";
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = Tawk_SRC;
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
        // });
    </script>
@endif


<!--start of Facebook Messenger Script-->
@if(basicControl()->fb_messenger_status)
    <div id="fb-root"></div>
    <script>
        "use strict";
        var fb_app_id = "{{ basicControl()->fb_app_id }}";
        window.fbAsyncInit = function () {
            FB.init({
                appId: fb_app_id,
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v10.0'
            });
        };
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
    <div class="fb-customerchat" page_id="{{ basicControl()->fb_page_id }}"></div>
@endif
<!--End of Facebook Messenger Script-->



@if(basicControl()->cookie_status == 1 && auth()->guard('web'))
    <script>
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + value + expires + "; path=/";
        }
        function hasAcceptedCookiePolicy() {
            return document.cookie.indexOf("cookie_policy_accepted=true") !== -1;
        }
        function hasClosedCookiePolicy() {
            return document.cookie.indexOf("cookie_policy_rejected=true") !== -1;
        }
        function acceptCookiePolicy() {
            setCookie("cookie_policy_accepted", "true", 365);
            document.getElementById("cookiesAlert").style.display = "none";
        }
        function closeCookieBanner() {
            setCookie("cookie_policy_rejected", "true", 365);
            document.getElementById("cookiesAlert").style.display = "none";
        }
        document.addEventListener('DOMContentLoaded', function () {
            if (!hasAcceptedCookiePolicy() && !hasClosedCookiePolicy()) {
                document.getElementById("cookiesAlert").style.display = "block";
            }
        });
    </script>

    <div class="cookies-alert" id="cookiesAlert">
        <img src="{{ asset('assets/global/img/cookie.svg') }}" height="50" width="50"
             alt="{{ basicControl()->site_title }} cookies">
        <h4 class="mt-2">@lang(basicControl()->cookie_title)</h4>
        <span class="d-block mt-2">@lang(basicControl()->cookie_sub_title).
            <a href="{{ basicControl()->cookie_url }}" class="link">@lang('see more')</a>
        </span>
        <a href="javascript:void(0);" class="mt-3 cmn-btn " type="button"
           onclick="acceptCookiePolicy()">@lang('Accept')</a>
        <a href="javascript:void(0);" class="mt-2 cmn-btn3" type="button" onclick="closeCookieBanner()">@lang('Close')</a>
    </div>
@endif


<script>
    "use strict";
    var root = document.querySelector(':root');
    root.style.setProperty('--primary-color', '{{basicControl()->primary_color}}');
    {{--root.style.setProperty('--heading-color', '{{basicControl()->secondary_color}}');--}}
</script>
