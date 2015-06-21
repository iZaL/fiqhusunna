@extends('layouts.three_col')

@section('banner')
    @include('partials.instagram')
@endsection

@section('right')
    @include('modules.blog.sidebar')
@endsection

@section('left')

    @include('modules.track.result',['title'=> trans('word.latest_tracks'), 'record'=>$latestTracks])

@endsection