<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <title>@yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.svg' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/common.css' )}}" />
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.min.css') }}" />
        @yield('style')
        <script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/core.ajaxauto.js' )}}"></script>
        @yield('script')
    </head>
    <body>
        <div>
            <header>
                @include('layout.includes.header')
            </header>

            <div id="wrapper">
                @yield('content')
            </div>

            <footer id="footer" class="footer">
                @include('layout.includes.footer')
            </footer>
        </div>
    </body>
</html>