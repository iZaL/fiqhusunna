@extends('layouts.three_col')

@section('title')
    {{ $album->name }}
@endsection

@section('breadcrumb')
    <div id="bc1" class="btn-group btn-breadcrumb pBottom20">
        <a href="{{url('home')}}" class="btn btn-default"><i class="fa fa-home"></i>&nbsp; </a>
        <a href="{{action('CategoryController@show',$album->category->id)}}" class="btn btn-default "><i class="fa fa-folder"></i> {{ $album->category->name }}</a>
        <a href="{{action('AlbumController@show',$album->id)}}" class="btn btn-default "><i class="fa fa-folder"></i> {{ $album->name }}</a>
    </div>
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