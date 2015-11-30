<div class="panel">
    <div class="panel-heading left-col-heading"><i
                class="fa fa-folder"></i> {{ isset($title) ? $title : trans('word.categories') }}</div>
    <div class="panel-body">
        <ul class="list-group">
            @foreach($categories as $category)
                <h5>
                    <li class="list-group-item"><a href="{{ action('CategoryController@getTrack',$category->id) }}"><i
                                    class="fa fa-folder"></i> {{ $category->name }}</a></li>
                </h5>
            @endforeach
        </ul>

    </div>
</div>