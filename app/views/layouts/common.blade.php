<!doctype html>
<html lang="ht">
    <head>
        <title>Sib Haiti - {{$title}}</title>
        <meta name="description" content="sistem idantifikasyon betay ayisyen">
		<meta name="description" content="sib">
		<meta name="author" content="cn.cherubin@gmail.com">
		<meta name="robots" content="noindex">
		<meta name="googlebot" content="noindex">
        <meta name="viewport" content="width=600, initial-scale=1">

        {{HTML::style('/frontapp/bootstrap/css/bootstrap.min.css')}}
        {{HTML::style('/frontapp/css/vars.css')}}
        {{HTML::style('/frontapp/style.css')}}
       
        {{HTML::script('/frontapp/bootstrap/js/jquery.js')}}
        {{HTML::script('/frontapp/bootstrap/js/bootstrap.min.js')}}
       
        {{HTML::script('/frontapp/js/jquery.maskedinput.js')}}
        
        {{HTML::script('/frontapp/js/frontScript.js')}}
     
    </head>
    <body>
        @yield('content')       
    </body>
</html>