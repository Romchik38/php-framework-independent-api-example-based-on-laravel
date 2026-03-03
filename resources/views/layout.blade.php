<!DOCTYPE html>
<html>
    <head>
        @section('head')
            <meta charset="UTF-8">
            <title>@yield('title', 'Wellcome')</title>
            <link rel="stylesheet" href="/css/bootstrap.min.css">
        @show
    </head>
    <body>
        @yield('content')
    </body>
</html>