@extends('layouts.master')

@section('content')

    <div class="no-gutter row">
        <div class="col-md-12">
            @yield('banner')
        </div>
    </div>

    <div class="no-gutter row">

        <div class="col-md-6">
            @yield('right')
        </div>

        <div class="col-md-6" id="content">
            @yield('left')
        </div>

    </div>

@endsection
