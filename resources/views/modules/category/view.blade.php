@extends('layouts.three_col')

@section('title')
    {{ $category->name }}
@endsection


@section('breadcrumb')
    <div id="bc1" class="btn-group btn-breadcrumb pBottom20">
        <a href="{{url('home')}}" class="btn btn-default"><i class="fa fa-home"></i>&nbsp; </a>
        <a href="{{action('CategoryController@show',$category->id)}}" class="btn btn-default "><i class="fa fa-folder"></i> {{ $category->name }}</a>
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
        <div class="panel-heading middle-col-heading" >{{ trans('word.albums') }}</div>
        <div class="panel-body">

            @foreach($category->albums as $album)
                <h5><a href="{{ action('AlbumController@show',$album->id) }}"><i
                                class="fa fa-headphones"></i> {{ $album->name }}</a></h5>
            @endforeach
        </div>
    </div>

@endsection

@section('right')
    @include('modules.category.sidebar')
@endsection

@section('left')
    <div class="panel" id="midCol">
        <div class="panel-heading" style="background-color:#555;color:#eee;">{{ trans('word.latest_tracks') }}</div>
        <div class="panel-body">

            @foreach($category->tracks as $track)
                <h5><a href="{{ action('TrackController@show',$track->id) }}"><i
                                class="fa fa-music"></i> {{ $track->name }}</a></h5>
            @endforeach
        </div>
    </div>
@endsection