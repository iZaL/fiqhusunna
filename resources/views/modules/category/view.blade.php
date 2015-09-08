@extends('layouts.three_col')

@section('title')
    {{ $category->name }}
@endsection

@section('breadcrumb')
    <div id="bc1" class="btn-group btn-breadcrumb pBottom20">
        <a href="{{url('home')}}" class="btn btn-default"><i class="fa fa-home"></i>&nbsp; </a>
        <a href="{{action('CategoryController@show',$category->id)}}" class="btn btn-default "><i
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

@section('middle')
    @include('modules.album.sidebar',['record'=>$category])
@endsection

@section('right')

    <div class="panel panel-default" id="sidebar">
        <div class="panel-heading right-col-heading" style="color: #FFF; background-color: #247F86; border-color: #ddd;">
            <i class="fa fa-folder-open"></i> {{trans('word.categories') }}  {{ isset($title) ? $title : '' }} </div>
        <div class="panel-body">
            <ul class="nav nav-stacked">
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
            </ul>
        </div>
        <!--/panel body-->
    </div>
@endsection

@section('left')
    @include('modules.track.sidebar',['record'=>$category])
@endsection