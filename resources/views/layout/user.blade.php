<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <title>@yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.svg' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/common.css' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/user.css' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('static/dist/css/font.css') }}" />
        <script type="text/javascript" src="{{ URL::asset('static/dist/js/jquery-3.1.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('static/dist/js/public.js' )}}"></script>
        <script type="text/javascript" src="{{ URL::asset('static/dist/js/core.popup.js' )}}"></script>
        <script type="text/javascript" src="{{ URL::asset('static/dist/js/core.ajaxauto.js' )}}"></script>
    </head>
    <body>
        @yield('content')
    </body>
</html>