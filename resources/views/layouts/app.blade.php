<?php if (!isset($ma)) {
 $ma = 0;
} ?>
  <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- CSRF Token -->
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <title>{{ config('app.name', 'Dictionnaire Tabwa-Français') }}</title>

 <link rel="stylesheet" href="{{asset('css/w3.css')}}">
 <!-- Styles -->
 {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
 <link rel="stylesheet" href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css">
 <link href="{{asset('vendor2/fonts/circular-std/style.css')}}" rel="stylesheet">
 <link rel="stylesheet" href="{{asset('vendor2/fonts/fontawesome/css/fontawesome-all.css')}}">
 <link rel="stylesheet" href="{{asset('vendor2/charts/chartist-bundle/chartist.css')}}">
 <link rel="stylesheet" href="{{asset('vendor2/charts/morris-bundle/morris.css')}}">
 <link rel="stylesheet" href="{{asset('vendor2/fonts/material-design-iconic-font/css/materialdesignicons.min.css')}}">
 <link rel="stylesheet" href="{{asset('vendor2/charts/c3charts/c3.css')}}">
 <link rel="stylesheet" href="{{asset('vendor2/fonts/flag-icon-css/flag-icon.min.css')}}">

</head>
<body>
<div id="app">
 @include('inc.navbar')
 <div class="w3-padding">
  <div class="container">
   <div class="container">
    @include('inc.messages')
   </div>
  </div>
  @yield('content')
 </div>
 <footer class="container w3-center">
  <small>&copy;2017-{{date('Y')}} Tabwa-Français Dictionnaire. All rights reserved.</small>
  <small>created by <a href="http://smirl.org">SmirlTech</a></small>

 </footer>
</div>

<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
<script src="{{asset('vendor2/jquery/jquery-3.3.1.min.js')}}"></script>
<!-- bootstap bundle js -->
<script src="{{asset('vendor2/bootstrap/js/bootstrap.bundle.js')}}"></script>
<!-- slimscroll js -->
<script src="{{asset('vendor2/slimscroll/jquery.slimscroll.js')}}"></script>
<!-- chart chartist js -->
<script src="{{asset('vendor2/charts/chartist-bundle/chartist.min.js')}}"></script>
<!-- sparkline js -->
<script src="{{asset('vendor2/charts/sparkline/jquery.sparkline.js')}}"></script>
<!-- morris js -->
<script src="{{asset('vendor2/charts/morris-bundle/raphael.min.js')}}"></script>
<script src="{{asset('vendor2/charts/morris-bundle/morris.js')}}"></script>
<!-- chart c3 js -->
<script src="{{asset('vendor2/charts/c3charts/c3.min.js')}}"></script>
<script src="{{asset('vendor2/charts/c3charts/d3-5.4.0.min.js')}}"></script>
<script src="{{asset('vendor2/charts/c3charts/C3chartjs.js')}}"></script>
<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
 CKEDITOR.replace('article-ckeditor');
</script>
</body>
</html>
