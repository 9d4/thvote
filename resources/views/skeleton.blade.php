@include('asset')
    <!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title') - You Decide</title>
    @stack('css')
</head>
<body>
<div class="wrapper">
    <div class="container" id="app">
        @yield('container')
        @include('footer')
    </div>
</div>
@stack('js')
</body>
</html>
