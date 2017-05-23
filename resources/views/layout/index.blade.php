<!DOCTYPE html>
<html lang="<?php echo LANG_LOCALE; ?>">
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.min.css') }}" />
    @yield('style')
    <script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
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