
<div class="panel" >
    <div class="panel-heading left-col-heading">{{ isset($title) ? $title : trans('word.latest_tracks') }}</div>
    <div class="panel-body">
        <ul class="list-group">
            @foreach($record as $track)
                <li class="list-group-item"><i class="fa fa-headphones album-list-icon"></i><a
                            href="{{ action('TrackController@show',$track->id) }}">{{$track->name}}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>