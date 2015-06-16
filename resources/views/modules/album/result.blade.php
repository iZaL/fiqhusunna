<div class="panel">
    <div class="panel-heading middle-col-heading">{{ isset($title) ? $title : trans('word.highest_visited_albums') }}</div>
    <div class="panel-body">
        <ul class="list-group">
            @foreach($record as $album)
                <li class="list-group-item">
                    <i class="fa fa-music album-list-icon"></i><a href="{{action('AlbumController@show',$album->id)}}"> {{ $album->name }}</a>
                </li>

            @endforeach

        </ul>
    </div>
</div>