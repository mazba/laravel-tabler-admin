<!doctype html>
<!--
Author: Md. Mazba Kamal
Version: 1.0
Website: www.mazbakamal.com
Contact: mazba.cse@gmail.com
-->
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in - {{env('APP_NAME')}}</title>
<!-- CSS files -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet"/>
</head>
<body class="antialiased border-top-wide border-primary d-flex flex-column">
@yield('content')
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="{{asset('js/tabler.js')}}"></script>
@yield('scripts')
</body>
</html>
