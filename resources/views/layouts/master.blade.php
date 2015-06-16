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
        <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
        {{--<link rel="stylesheet" href="css/all.css">--}}
        <style>
            @import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);

            html, body {
                font-family: 'Droid Arabic Kufi' !important;
            }

            h1, h2, h3, h4, span, p, div, table {
                font-family: 'Droid Arabic Kufi' !important;
            }
        </style>
    @show

    @section('script')
        <script src="{{ elixir('js/app.js') }}"></script>
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
