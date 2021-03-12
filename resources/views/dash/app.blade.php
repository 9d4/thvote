@include('asset')
@include('dash.template.menu')
    <!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title') - You Decide</title>
    @stack('css')
</head>
<body>
<div class="wrapper">
    <div class="container-fluid" id="app">
        <div class="">
            @include('user.template.banner')
        </div>

        <div class="row my-4">
            <div class="col col-12 col-md-3">@stack('menu')</div>
            <div class="col col-12 col-md-9">
                @yield('right')
            </div>
        </div>
    </div>
</div>
@stack('js')
</body>
</html>
