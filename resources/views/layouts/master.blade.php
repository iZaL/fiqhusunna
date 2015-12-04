<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="nl"><![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="nl"><![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="nl"><![endif]-->
<!--[if IE]>
<html class="no-js ie" lang="nl"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js" lang="nl"><!--<![endif]-->

<head>

    <meta charset="utf-8">
    <title>@yield(e('title'),'Fiqhussunna')</title>
    <meta name="description" content="Fiqhussunna.com">
    <meta name="keywords" content="Fiqhussunna, Islamic law, Sharia, Fiqh">
    <meta name="author" content="pnabdurahman@gmail.com">
    <meta name="viewport" content="width=device-width">

    @section('style')
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
        {{--<link rel="stylesheet" href='/bower_components/bootstrap/dist/css/bootstrap.min.css',>--}}
        {{--<link rel="stylesheet" href='/bower_components/fontawesome/css/font-awesome.min.css'>--}}
        {{--<link rel="stylesheet" href='/css/jplayer.css'>--}}
        {{--<link rel="stylesheet" href="/css/style.css">--}}
        {{--<link rel="stylesheet" href="/css/dropdown-menu.css">--}}
    @show
    <link href="http://fonts.googleapis.com/css?family=Lato:400,900,300,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic,700italic" rel="stylesheet">
</head>

<body>

@include('partials.header')
@include('partials.nav')

<div class="container">

    @include('partials.notifications')

    @section('content')
    @show

</div>

@include('partials.footer')

@section('script')
    <script src="{{ elixir('js/app.js') }}"></script>
@show
</body>

</html>
