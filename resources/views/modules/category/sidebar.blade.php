@inject('category','App\Src\Category\Category')

<div class="panel panel-default" id="sidebar">
    <div class="panel-heading" style="background-color:#888;color:#fff;">{{ trans('word.categories') }}</div>
    <div class="panel-body">
        <ul class="nav nav-stacked">
            @foreach($category->all() as $category)
                <li><a href="{{action('CategoryController@show',str_slug($category->id))}}"><i class="fa fa-folder"></i> {{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <!--/panel body-->
</div>