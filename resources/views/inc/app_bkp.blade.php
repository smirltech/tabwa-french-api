<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="{{asset('css/w3.css')}}">
 <link rel="stylesheet" href="{{asset('css/app.css')}}">

 <title>{{config('app.name', 'LFNN2')}}</title>

</head>
<body>
@include('inc.navbar')
<div class="container">
 @include('inc.messages')
 @yield('content')
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>

</html>
