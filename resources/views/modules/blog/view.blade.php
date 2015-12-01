@extends('layouts.two_col')

@section('title')
    {{ $article->title }}
@endsection

@section('left')
    <div class="panel">
        <div class="panel-heading left-col-heading"><i
                    class="fa fa-folder"></i> {{ $selectedCategory->name }}</div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($parentCategories as $category)
                    <h5>
                        <li class="list-group-item
                        @if(!is_null($selectedCategory) && $category->id == $selectedCategory->id)
                                active
                            @endif
                                "><a
                                    href="{{ action('CategoryController@getArticle',$category->id) }}"><i
                                        class="fa fa-folder"></i> {{ ucfirst($category->name) }}</a>

                            <ul class="list-group pTop10">

                                @foreach($category->childCategories as $child)
                                    <li class="list-group-item
                                        @if(!is_null($selectedCategory) && $child->id == $selectedCategory->id)
                                            active
                                        @endif
                                            "><a
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

    <div class="panel">
        <div class="panel-heading blog-title" >{{ ucfirst($article->title) }}</div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row article">
                    <i class="fa fa-calendar"></i>&nbsp; {{ $article->created_at->format('l, M j,Y ') }}
                    <hr>
                    {!! $article->description !!}
                    <hr>
                    <div class="authorInfo">
                        author : {{ ucfirst($article->user->name) }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="clear:both"></div>

@endsection
