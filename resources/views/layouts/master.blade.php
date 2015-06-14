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
        <style>
            @import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);
            html,body {
                font-family: 'Droid Arabic Kufi' !important;
            }
            h1,h2,h3,h4,span,p,div,table {
                font-family: 'Droid Arabic Kufi' !important;
            }
        </style>
        <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/bootstrap-flat.css" rel="stylesheet">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        @if(App::getLocale() == 'ar')
            <link href="/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.css" rel="stylesheet">
        @endif
        <link rel="stylesheet" href="/bower_components/fontawesome/css/font-awesome.min.css" type="text/css"/>
        <link rel="stylesheet" href="/css/style.css">

    @show

    @section('script')
        <script src="/js/config.js"></script>
        <script src="/bower_components/modernizr/modernizr.js"></script>

        <!-- jQuery -->
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

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
