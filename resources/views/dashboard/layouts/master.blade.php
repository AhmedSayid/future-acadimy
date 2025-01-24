<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @include('dashboard.layouts.head')
</head>

<body class="main-body app sidebar-mini">
<!-- Loader -->
<div id="global-loader">
    <img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->
@include('dashboard.layouts.main-sidebar')
<!-- main-content -->
<div class="main-content app-content">
    @include('dashboard.layouts.main-header')
    <!-- container -->
    <div class="container-fluid">
        @yield('page-header')
        @yield('content')
        @include('dashboard.layouts.sidebar')
        @include('dashboard.layouts.models')
        @include('dashboard.layouts.footer')
        @include('dashboard.layouts.footer-scripts')
    </div>
    <!-- Container closed -->
</div>
<!-- main-content closed -->
</body>
</html>
