
<div class="panel" >
    <div class="panel-heading left-col-heading">{{ isset($title) ? $title : trans('word.latest_tracks') }}</div>
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