    <ul class="nav navbar-nav">
        <li class="dropdown dropdown-large">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('word.articles')}} <b
                        class="caret"></b></a>
            <ul class="col-md-11 dropdown-menu dropdown-menu-large row">
                <li class="dropdown-header"><a
                            href="{{ action('BlogController@index') }}">{{ trans('word.all_articles') }}</a></li>
                @foreach($articleCategories as $category)
                    <li class="col-sm-3">
                        <ul>
                            <li class="dropdown-header" style="float: left"><a
                                        href="{{action('CategoryController@getArticle',$category->id)}}"> {{ ucfirst($category->name) }}</a>
                            </li>
                            @foreach($category->childCategories as $child)
                                <li class="innerHeader"><a class="innerHeader"
                                                           href="{{action('CategoryController@getArticle',$child->id)}}">{{ ucfirst($child->name) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>