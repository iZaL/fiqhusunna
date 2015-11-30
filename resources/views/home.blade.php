@extends('layouts.three_col')

@section('banner')
    {{--@include('partials.instagram')--}}
@endsection

@section('middle')
    @include('modules.blog.latest',['articles'=>$articles])
@endsection

@section('right')
    @include('modules.track.result',['title'=> trans('word.latest_tracks'), 'record'=>$latestTracks])
@endsection

@section('left')
    @include('modules.blog.sidebar',['categories'=>$blogCategories])
@endsection