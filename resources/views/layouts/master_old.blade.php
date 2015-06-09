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
    <title>@yield(strip_tags('title'),'Sound')</title>
    <meta name="description" content="Page description here">
    <meta name="author" content="BigBase - D. Tiems">
    <meta name="viewport" content="width=device-width">

    @section('style')

        <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        @if(App::getLocale() == 'ar')
            <link href="/bower_components/bootstrap-rtl/dist/css/bootstrap-rtl.css" rel="stylesheet">
        @endif
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=McLaren">
        <link rel="stylesheet" href="/bower_components/nivoslider/nivo-slider.css">
        <link rel="stylesheet" href="/bower_components/colorbox/example1/colorbox.css">
        <link rel="stylesheet" href="/bower_components/nivoslider/themes/bar/bar.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="/bower_components/nivoslider/themes/light/light.css" type="text/css" media="screen"/>
        <link rel="stylesheet" href="/bower_components/fontawesome/css/font-awesome.min.css" type="text/css"/>
        <link rel="stylesheet" href="/css/styles.css">

    @show

    @section('script')
        <script src="/js/config.js"></script>
        <script src="/bower_components/modernizr/modernizr.js"></script>

        <!-- jQuery -->
        <script src="/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script src="/bower_components/nivoslider/jquery.nivo.slider.pack.js"></script>
        <script src="/bower_components/colorbox/jquery.colorbox-min.js"></script>
        <script src="/bower_components/respond/dest/respond.min.js"></script>
        <script src="/js/scripts.js"></script>
    @show

</head>

<body>

<div class="container">

    @include('partials.header')

    @yield('title')

    @include('partials.notifications')

    @section('content')
    @show

    @include('partials.subfooter')

    @include('partials.footer')

</div>

</body>


</html>
