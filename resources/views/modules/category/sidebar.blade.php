@inject('category','App\Src\Category\Category')

<div class="panel panel-default" id="sidebar">
    <div class="panel-heading right-col-heading" style="color: #FFF; background-color: #247F86; border-color: #ddd;">
        <i class="fa fa-folder-open"></i> {{trans('word.categories') }}  {{ isset($title) ? $title : '' }} </div>
    <div class="panel-body">
        <ul class="nav nav-stacked">
            @foreach($category->with('thumbnail')->get() as $category)
                <li>
                    <a href="{{action('CategoryController@show',str_slug($category->id))}}">
                        @if($category->thumbnail)
                            <img src="/uploads/thumbnail/{{ $category->thumbnail->name}}"
                                 class="img-responsive img-thumbnail img-25x25">
                        @else
                            <i class="fa fa-folder"></i>
                        @endif
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <!--/panel body-->
</div>