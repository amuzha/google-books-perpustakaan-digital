<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MuzhaffaR: @yield('title', 'Perpustakaan')</title>

    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap/bootstrap-grid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap/bootstrap-reboot.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/owl/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/jquery/jquery.countdown.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/style.css') }}">

    @include('user.layouts.custom-css')
</head>
<body class="dark-scheme de-clivus">
    <div id="wrapper">
        @include('user.layouts.header')

        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            @yield('content')
        </div>

        @include('user.layouts.footer')
    </div>

    <script src="{{ asset('public/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.isotope.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.plugin.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.countTo.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.countdown.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery/jquery.lazy.plugins.min.js') }}"></script>

    <script src="{{ asset('public/assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('public/assets/js/owl/owl.carousel.js') }}"></script>

    <script src="{{ asset('public/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/easing.js') }}"></script>
    <script src="{{ asset('public/assets/js/validation.js') }}"></script>
    <script src="{{ asset('public/assets/js/enquire.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/validation.js') }}"></script>
    <script src="{{ asset('public/assets/js/designesia.js') }}"></script>
    <script src="{{ asset('public/assets/js/particles.js') }}"></script>
    <script src="{{ asset('public/assets/js/particles-settings.js') }}"></script>

    @yield('script')
</body>
</html>
