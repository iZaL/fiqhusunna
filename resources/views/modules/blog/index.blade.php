@extends('layouts.two_col')

@section('title')
    {{ trans('word.blog') }}
@endsection

@section('left')
    <div class="panel">
        <div class="panel-heading left-col-heading"><i
                    class="fa fa-folder"></i> {{ isset($title) ? $title : trans('word.categories') }}</div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($parentCategories as $category)
                    <h5>
                        <li class="list-group-item"><a
                                    href="{{ action('CategoryController@getArticle',$category->id) }}"><i
                                        class="fa fa-folder"></i> {{ ucfirst($category->name) }}</a>

                            <ul class="list-group pTop10">

                                @foreach($category->childCategories as $child)
                                    <li class="list-group-item"><a
                                                href="{{ action('CategoryController@getArticle',$child->id) }}">
                                            {{ ucfirst($child->name) }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </h5>

                @endforeach
            </ul>

        </div>
    </div>
@endsection
@section('right')
    @include('modules.blog._loop',['articles'=>$articles])
@endsection
