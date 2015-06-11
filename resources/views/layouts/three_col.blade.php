@extends('layouts.master')

@section('content')

    <div class="no-gutter row">

        <div class="col-md-2">
            @yield('right')
        </div>

        <div class="col-md-5">
            @yield('middle')
        </div>

        <div class="col-md-5" id="content">
            @yield('left')
        </div>

    </div>

@endsection
