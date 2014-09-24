<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bob's woordzoeker{{ isset($page) ? ' | ' . $page : '' }}</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/woordzoeker.css') }}" rel="stylesheet">
</head>

<body>
    <div id="container">
        <h1>Bob's woordzoeker</h1>
        @yield('content')
    </div>

    <script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-slider.js') }}"></script>
    <script src="{{ asset('js/woordzoeker.js') }}"></script>
</body>
</html>
