<div class="panel">
    <div class="panel-heading left-col-heading"><i
                class="fa fa-folder"></i> {{ isset($title) ? $title : trans('word.categories') }}</div>
    <div class="panel-body">
        {{--<ul class="list-group">--}}
        {{--@foreach($categories as $category)--}}
        {{--<h5>--}}
        {{--<li class="list-group-item"><a href="{{ action('CategoryController@getArticle',$category->id) }}"><i--}}
        {{--class="fa fa-folder"></i> {{ ucfirst($category->name) }}</a></li>--}}
        {{--</h5>--}}


        {{--@endforeach--}}
        {{--</ul>--}}
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu"
            style="display: block; position: static; margin-bottom: 5px; *width: 180px;">

            @foreach($categories as $category)
                <li class="dropdown-submenu"><a href="{{ action('CategoryController@getArticle',$category->id) }}"><i
                                class="fa fa-folder"></i> {{ ucfirst($category->name) }}</a>
                @if($category->childCategories)
                    <ul class="dropdown-menu">
                        @foreach($category->childCategories as $child)
                            <li>
                                <a href="{{ action('CategoryController@getArticle',$child->id) }}">{{ $child->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
