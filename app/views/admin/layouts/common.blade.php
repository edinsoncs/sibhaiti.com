<!doctype html>
<html lang="EN">
    <head>
        <title>{{$title}}</title>
        <meta name="description" content="">

        {{HTML::style('../frontapp/bootstrap/css/bootstrap.min.css')}}
        {{HTML::style('../frontapp/css/vars.css')}}
        {{HTML::style('../frontapp/admin/style.css')}}
        {{HTML::style('../frontapp/style.css')}}
        {{HTML::script('../frontapp/bootstrap/js/jquery.js')}}
        {{HTML::script('../frontapp/bootstrap/js/bootstrap.min.js')}}
        {{HTML::script('../frontapp/js/jquery.maskedinput.js')}}

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        @yield('content')       
    </body>
</html>