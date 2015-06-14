@extends('layouts.three_col')

@section('banner')
{{--    @include('partials.instagram')--}}
@endsection

@section('right')
    @include('modules.category.sidebar')
@endsection

@section('left')
    <div class="panel" >
        <div class="panel-heading middle-col-heading">{{ trans('word.latest_tracks') }}</div>
        <div class="panel-body">
            <ul class="album-list">
                @foreach($latestTracks as $track)
                    <li><i class="fa fa-headphones album-list-icon"></i><a
                                href="{{ action('TrackController@show',$track->id) }}">{{$track->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="panel" >
        <div class="panel-heading middle-col-heading">{{ trans('word.highest_listened_tracks') }}</div>
        <div class="panel-body">
            <ul class="album-list">
                @foreach($topTracks as $track)
                    <li><i class="fa fa-headphones album-list-icon"></i><a
                                href="{{ action('TrackController@show',$track->id) }}">{{$track->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="panel" >
        <div class="panel-heading middle-col-heading">{{ trans('word.highest_listened_tracks') .' '.trans('word.this_month') }}</div>
        <div class="panel-body">
            <ul class="album-list">
                @foreach($topTracksForThisMonth as $track)
                    <li><i class="fa fa-headphones album-list-icon"></i><a
                                href="{{ action('TrackController@show',$track->id) }}">{{$track->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="panel" >
        <div class="panel-heading middle-col-heading">{{ trans('word.highest_listened_tracks') .' '.trans('word.today') }}</div>
        <div class="panel-body">
            <ul class="album-list">
                @foreach($topTracksForToday as $track)
                    <li><i class="fa fa-headphones album-list-icon"></i><a
                                href="{{ action('TrackController@show',$track->id) }}">{{$track->name}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


    @include('modules.blog.sidebar')
@endsection

@section('script')
    @parent
    <script>

    </script>
@endsection

@section('middle')

    <div class="panel" >
        <div class="panel-heading middle-col-heading">{{ trans('word.latest_albums') .' '. trans('word.added') }}</div>
        <div class="panel-body">
            @foreach($albums as $album)
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-4">
                        <img src="http://placehold.it/100x150/EEEEEE" class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-8">
                        <ul class="album-list">
                            <p class="title"><a
                                        href="{{action('AlbumController@show',$album->id)}}"> {{ $album->name }}</a></p>
                            @foreach($album->recentTracks as $track)
                                <li><i class="fa fa-headphones album-list-icon"></i><a
                                            href="{{ action('TrackController@show',$track->id) }}">{{$track->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endsection
