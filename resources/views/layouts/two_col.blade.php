@extends('layouts.master')

@section('content')

    <div class="no-gutter row">
        <div class="col-md-12">
            @yield('banner')
        </div>
    </div>

    <div class="no-gutter row">

        <div class="col-md-3" id="content">
            @yield('left')
        </div>

        <div class="col-md-9">
            @yield('right')
        </div>

    </div>

@endsection
