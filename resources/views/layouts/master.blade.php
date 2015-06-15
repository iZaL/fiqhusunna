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
    <title>@yield(e('title'),'Sound')</title>
    <meta name="description" content="Page description here">
    <meta name="author" content="BigBase - D. Tiems">
    <meta name="viewport" content="width=device-width">

    @section('style')
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="/bower_components/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/jplayer.css">
        <link rel="stylesheet" href="/css/style.css">
    @show

    @section('script')
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/bower_components/jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
        <script src="/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script src="/js/script.js"></script>
    @show

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

</body>


</html>
