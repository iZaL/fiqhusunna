<div class="panel" id="midCol">
    <div class="panel-heading middle-col-heading">{{ trans('word.albums') }}</div>
    <div class="panel-body">
        <ul class="list-group">

            @foreach($record->albums as $album)
                <h5>
                    <li class="list-group-item">
                        @if($album->thumbnail)
                            <img src="/uploads/thumbnail/{{ $album->thumbnail->name}}"
                                 class="img-responsive img-thumbnail img-tiny">
                        @else
                            <img src="http://placehold.it/50x50/EEEEEE" class="img-responsive img-thumbnail">
                        @endif
                        <a href="{{ action('AlbumController@show',$album->id) }}"> {{ $album->name }}</a>
                    </li>
                </h5>
            @endforeach
        </ul>
    </div>
</div>