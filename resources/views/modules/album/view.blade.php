@extends('layouts.three_col')

@section('title')
    {{ $album->name }}
@endsection

@section('style')
    @parent
    <link href="/bower_components/jquery-ui/themes/hot-sneaks/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jplayer.css" rel="stylesheet">
@endsection

@section('script')
    @parent
@endsection

@section('middle')
    <div class="panel" id="midCol">
        <div class="panel-heading middle-col-heading" >{{ trans('word.latest_tracks') }}</div>
        <div class="panel-body">

            @foreach($album->tracks as $track)
                <h5><a href="{{ action('TrackController@show',$track->id) }}"><i
                                class="fa fa-music"></i> {{ $track->name }}</a></h5>
            @endforeach
        </div>
    </div>
@endsection

@section('right')
    @include('modules.category.sidebar')
@endsection

@section('left')

@endsection