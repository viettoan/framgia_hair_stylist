<!DOCTYPE html>
<html class="no-js"> 
<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    {{ Html::style('bower/icomoon-bower/style.css') }}
    {{ Html::style('bower/animate.css/animate.css') }}
    {{ Html::style('bower/simple-line-icons/css/simple-line-icons.css')}}
    {{ Html::style('bower/owl.carousel/dist/assets/owl.carousel.min.css') }}
    {{ Html::style('bower/owl.carousel/dist/assets/owl.theme.default.min.css') }}
    {{ Html::style('bower/bootstrap/dist/css/bootstrap.css') }}
    {{ Html::style('bower/toastr/toastr.min.css') }}
    {{ Html::style('css/style.css') }}
    @yield('style')
</head>
<body>
    @yield('content')
    {{ Html::script('bower/vue/dist/vue.js') }}
    {{ Html::script('bower/vue-ls/dist/vue-ls.js') }}
    {{ Html::script('bower/vue-ls/dist/vue-ls.min.js') }}
    {{ Html::script('bower/jquery/dist/jquery.min.js') }}
    {{ Html::script('bower/toastr/toastr.min.js') }}
    {{ Html::script('bower/axios/dist/axios.min.js') }}
    {{ Html::script('bower/modernizr-2.6.2.min/index.js') }}
    {{ Html::script('bower/jquery-2.1.4.min/index.js') }}
    {{ Html::script('bower/jquery.easing/js/jquery.easing.js') }}
    {{ Html::script('bower/bootstrap/dist/js/bootstrap.min.js') }}
    {{ Html::script('bower/waypoints/lib/jquery.waypoints.min.js') }}
    {{ Html::script('bower/owl.carousel/docs/assets/owlcarousel/owl.carousel.min.js') }}
    {{ Html::script('bower/jquery-style-switcher/jQuery.style.switcher.js') }}
    {{ Html::script('js/booking.js')}}
    {{ Html::script('js/main.js')}}
    {{ Html::script('js/header.js')}}
    @yield('script')
</body>
</html>
