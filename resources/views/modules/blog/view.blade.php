@extends('layouts.two_col')

@section('title')
    {{ $post->title }}
@endsection

@section('left')
    <div class="panel">
        <div class="panel-heading left-col-heading"><i
                    class="fa fa-folder"></i> {{ ucfirst($category->name) }}</div>
        <div class="panel-body">
            <ul class="list-group">
                @foreach($category->childCategories as $child)
                    <h5>
                        <li class="list-group-item"><a href="{{ action('CategoryController@getArticle',$child->id) }}"><i
                                        class="fa fa-folder"></i> {{ ucfirst($child->name) }}</a></li>
                    </h5>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('right')

    <div class="panel">
        <div class="panel-heading blog-title" >{{ ucfirst($post->title) }}</div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row article">
                    <i class="fa fa-calendar"></i>&nbsp; {{ $post->created_at->format('l, M j,Y ') }}
                    <hr>
                    {!! $post->description !!}
                    <hr>
                    <div class="authorInfo">
                        author : {{ ucfirst($post->user->name) }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="clear:both"></div>

@endsection
