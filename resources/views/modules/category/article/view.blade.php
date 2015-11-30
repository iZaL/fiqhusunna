@extends('layouts.two_col')

@section('title')
    {{ $category->name }}
@endsection

@section('breadcrumb')
    <div id="bc1" class="btn-group btn-breadcrumb pBottom20">
        <a href="{{url('home')}}" class="btn btn-default"><i class="fa fa-home"></i>&nbsp; </a>
        <a href="{{action('CategoryController@getTrack',$category->id)}}" class="btn btn-default "><i
                    class="fa fa-folder"></i> {{ $category->name }}</a>
    </div>
@endsection

@section('style')
    @parent
    <link href="/bower_components/jquery-ui/themes/hot-sneaks/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/jplayer.css" rel="stylesheet">
@endsection

@section('script')
    @parent
@endsection

@section('left')
    @include('modules.blog.sidebar',['categories'=>$blogCategories])
@endsection

@section('right')
    <div class="panel" id="midCol">
        <div class="panel-heading middle-col-heading">{{ trans('word.articles') }}</div>
        <div class="panel-body">

            @foreach($articles as $article)
                <h2><a href="{{ action('BlogController@show',$article->id) }}">{{ $article->title }}</a></h2>

                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ action('BlogController@show',$article->id) }}">
                            @if($article->thumbnail)
                                <img src="/uploads/thumbnail/{{ $article->thumbnail->name}}"
                                     class="img-responsive img-thumbnail">
                            @else
                                <img src="http://placehold.it/150x100/EEEEEE" class="img-responsive img-thumbnail">
                            @endif
                        </a>
                    </div>
                    <div class="col-md-9">
                        {!! str_limit($article->description,100) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <button class="btn btn-default mTop10"><a
                                    href="{{ action('BlogController@show',$article->id) }}">More</a></button>
                    </div>
                </div>

                <hr>
            @endforeach


        </div>
    </div>
@endsection
