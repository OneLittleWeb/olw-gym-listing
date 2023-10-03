<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex,nofollow">
    <meta name="googlebot" content="noindex,nofollow">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="author" content="TechyDevs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - {{base_path()}} Admin</title>
    <!-- Favicon -->
    <link rel="icon" href="{{asset('/images/favicon.png')}}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam:wght@100;300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Template CSS Files -->
    <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/animated-headline.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('/css/chosen.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    {{--    font awesome cdn--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">

    @yield('css')
</head>
<body>

<!-- ================================
    START DASHBOARD AREA
================================= -->
<section class="dashboard-wrap d-flex">
    @include('admin.partials.sidebar')
    <div class="dashboard-body d-flex flex-column">
        <div class="dashboard-inner-body flex-grow-1">
            @include('admin.partials.header')
            @yield('content')

        </div><!-- end dashboard-inner-body -->
        <div class="dashboard-footer bg-white">
            <div class="container-fluid">
                <div class="copy-right d-flex align-items-center justify-content-between">
                    <p class="copy__desc">
                        &copy; Copyright SerpKick {{date('Y')}} . Made with
                        <span class="la la-heart-o"></span>
                    </p>
                </div>
            </div>
        </div>
    </div><!-- end dashboard-body -->
</section>
<!-- ================================
    START DASHBOARD AREA
================================= -->

<!-- Template JS Files -->
<script src="{{asset('/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('/js/jquery-ui.js')}}"></script>
<script src="{{asset('/js/popper.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('/js/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('/js/animated-headline.js')}}"></script>
<script src="{{asset('/js/chosen.min.js')}}"></script>
<script src="{{asset('/js/moment.min.js')}}"></script>
<script src="{{asset('/js/datedropper.min.js')}}"></script>
<script src="{{asset('/js/waypoints.min.js')}}"></script>
<script src="{{asset('/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('/js/jquery-rating.js')}}"></script>
<script src="{{asset('/js/tilt.jquery.min.js')}}"></script>
<script src="{{asset('/js/jquery.lazy.min.js')}}"></script>
<script src="{{asset('/js/main.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{!! Toastr::message() !!}
@yield('js')
@include('sweetalert::alert')
</body>
</html>
