<ul class="nav navbar-nav">
    <li class="dropdown dropdown-large">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('word.track')}} <b
                    class="caret"></b></a>
        <ul class="col-md-11 dropdown-menu dropdown-menu-large row">
            <li class="dropdown-header"><a
                        href="{{ action('TrackController@index') }}">{{ trans('word.all_tracks') }}</a></li>
            @foreach($trackCategories as $category)
                <li class="col-sm-3">
                    <ul>
                        <li class="dropdown-header"><a
                                    href="{{action('CategoryController@getTrack',$category->id)}}"> {{ ucfirst($category->name) }}</a>
                        </li>
                        @foreach($category->albums as $album)
                            <li class="innerHeader"><a class="innerHeader"
                                                       href="{{action('AlbumController@show',$album->id)}}">{{ ucfirst($album->name) }}</a>
                            </li>
                        @endforeach
                        <li class="divider"></li>
                    </ul>
                </li>
            @endforeach
        </ul>
    </li>
</ul>
