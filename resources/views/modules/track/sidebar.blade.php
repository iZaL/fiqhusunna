<div class="panel" >
    <div class="panel-heading middle-col-heading"><i class="fa fa-headphones"></i> {{ trans('word.latest_tracks') }}</div>
    <div class="panel-body">

        <ul class="list-group">
            @foreach($record->tracks as $track)
                <h5>
                    <li class="list-group-item"><a href="{{ action('TrackController@show',$track->id) }}"><i
                                    class="fa fa-headphones"></i> {{ $track->name }}</a></li>
                </h5>
            @endforeach
        </ul>

    </div>
</div>