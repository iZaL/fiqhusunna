    <ul class="nav navbar-nav">
        <li class="dropdown dropdown-large">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('word.browse')}} <b
                        class="caret"></b></a>

            <ul class="dropdown-menu dropdown-menu-large row">
                @foreach($categories as $category)
                    <li class="col-sm-3">
                        <ul>
                            <li class="dropdown-header"><a
                                        href="{{action('CategoryController@show',$category->id)}}"> {{ $category->name }}</a>
                            </li>
                            @foreach($category->albums as $album)
                                <li class="innerHeader"><a class="innerHeader" href="{{action('AlbumController@show',$category->id)}}">{{ $album->name }}</a>
                                </li>
                            @endforeach
                            <li class="divider"></li>
                        </ul>

                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
