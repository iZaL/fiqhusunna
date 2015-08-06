@extends('layouts.three_col')

@section('banner')
    @include('partials.instagram')
@endsection

@section('middle')
    @include('modules.blog.sidebar')
@endsection

@section('right')
    @include('modules.category.sidebar')
@endsection

@section('left')

    @include('modules.track.result',['title'=> trans('word.latest_tracks'), 'record'=>$latestTracks])

@endsection