@extends('layouts.three_col')

@section('banner')
    @include('partials.instagram')
@endsection

@section('right')
    @include('modules.category.sidebar')
@endsection

@section('left')

    @include('modules.track.result',['title'=> trans('word.latest_tracks'), 'record'=>$latestTracks])
    @include('modules.track.result',['title'=> trans('word.highest_listened_tracks'), 'record'=>$topTracks])
    @include('modules.track.result',['title'=> trans('word.highest_listened_tracks') .' '.trans('word.this_month'), 'record'=>$topTracksForThisMonth])
    @include('modules.track.result',['title'=> trans('word.highest_listened_tracks').' '.trans('word.today'), 'record'=>$topTracksForToday])

    @include('modules.blog.sidebar')
@endsection

@section('script')
    @parent
    <script>

    </script>
@endsection

@section('middle')

    <div class="panel">
        <div class="panel-heading middle-col-heading">{{ trans('word.latest_albums') .' '. trans('word.added') }}</div>
        <div class="panel-body">
            @foreach($albums as $album)
                <div class="row">

                    <div class="col-md-3 col-sm-4 col-xs-4">
                        @if($album->thumbnail)
                            <img src="/uploads/thumbnail/{{ $album->thumbnail->name}}"
                                 class="img-responsive img-thumbnail img-album-thumb">
                        @else
                            <img src="http://placehold.it/100x150/EEEEEE"
                                 class="img-responsive img-thumbnail img-album-thumb">
                        @endif

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
