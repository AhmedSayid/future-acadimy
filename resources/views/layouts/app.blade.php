<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="">
    <link rel="icon" type="image/png" loading="lazy" href="../assets/front/assets/img/logos/Focus_logo2.png" >
    <title>Focus Academy</title>
{{--    <meta name="description" content="منصة تعليمية تقدم دورات في مادة التاريخ الثانوية العامة المصرية، بتدريس واضح ومبسط من المدرس عبدالرحمن الشيخ لطلاب الثانويه العامه شرح التاريخ للصف الاول والثاني والثالث الثانوي متابعة مستمرة ورفع مستوي معا لنتفوق.">--}}
{{--    <meta name="author" content="المنصة التعليميه لمستر عبدالرحمن الشيخ">--}}
{{--    <meta name="keywords" content="تاريخ، تعليم، ثانوية عامة، مصر، كورسات، عبدالرحمن الشيخ,منصة عبدالرحمن الشيخ , مستر عبدالرحمن الشيخ , منصات تعليميه , منصة تعليميه لشرح التاريخ, حل اسئلة تاريخ,ثانويه عامه,تاريخ ثانويه عامه, حل اسئلة التاريخ,منصة,abdelrahman,abdelrahman elshaikh">--}}
{{--    <meta name="robots" content="index, follow">--}}
{{--    <link rel="canonical" href="https://abdelrahman-elshaikh.com">--}}
{{--    <meta property="og:title" content="منصة كورسات تعليمية لمادة التاريخ الثانوية العامة ">--}}
{{--    <meta property="og:description" content="منصة تعليمية تقدم دورات في مادة التاريخ الثانوية العامة ، بتدريس واضح ومبسط من المدرس عبدالرحمن الشيخ.">--}}
{{--    <meta property="og:image" content="https://abdelrahman-elshaikh.com/../assets/front/assets/img/logo-elshiek.png">--}}
{{--    <meta property="og:url" content="https://abdelrahman-elshaikh.com/">--}}
{{--    <script type="application/ld+json">--}}
{{--        {--}}
{{--          "@context": "http://schema.org",--}}
{{--          "@type": "WebPage",--}}
{{--          "name": "منصة كورسات تعليمية لمادة التاريخ الثانوية العامة المصرية",--}}
{{--          "description": "منصة تعليمية تقدم دورات في مادة التاريخ الثانوية العامة المصرية، بتدريس واضح ومبسط من المدرس عبدالرحمن الشيخ."--}}
{{--        }--}}
{{--    </script>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{asset('assets/front/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/front/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{asset('assets/front/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/front/assets/css/soft-ui-dashboard.css?v=1.0.3')}}" rel="stylesheet" />
    <link href="{{asset('assets/front/assets/css/main.css')}}" rel="stylesheet" />
    <link id="pagestyle" href="{{asset('assets/front/assets/css/soft-ui-dashboard.min.css?v=1.1.1')}}" rel="stylesheet" />
    @yield('head')
</head>
<body id="body" class="g-sidenav-show  bg-gray-100 rtl">
@auth
    @yield('auth')
@endauth
@guest
    @yield('guest')
@endguest
<!--   Core JS Files   -->
<script src="{{asset('assets/front/assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/front/assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/front/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/front/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/front/assets/js/plugins/dragula/dragula.min.js')}}"></script>
<script src="{{asset('assets/front/assets/js/plugins/jkanban/jkanban.js')}}"></script>
<script src="{{asset('assets/front/assets/js/soft-ui-dashboard.min.js?v=1.1.1')}}"></script>
@stack('rtl')
@stack('dashboard')
@yield('script')
<script src="{{asset('assets/front/assets/js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
</body>
</html>
