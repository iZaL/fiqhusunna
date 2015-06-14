<div class="panel" id="midCol">
    <div class="panel-heading middle-col-heading"><i class="fa fa-music"></i> {{ trans('word.albums') }}</div>
    <div class="panel-body">
        <ul class="list-group">

            @foreach($record->albums as $album)
                <h5>
                    <li class="list-group-item">
                        @if($album->thumbnail)
                            <img src="/uploads/thumbnail/{{ $album->thumbnail->name}}"
                                 class="img-responsive img-thumbnail img-tiny">
                        @else
                            <i class="fa fa-music img-responsive  "></i>
                        @endif
                        <a href="{{ action('AlbumController@show',$album->id) }}"> {{ $album->name }}</a>
                    </li>
                </h5>
            @endforeach
        </ul>
    </div>
</div>