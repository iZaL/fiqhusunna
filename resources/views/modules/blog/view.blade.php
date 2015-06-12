@extends('layouts.one_col')

@section('title')
    {{ $post->title }}
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading" style="background-color:#111;color:#fff;">{{ trans('word.blog') }}</div>
        <div class="panel-body">
            <div class="col-md-12">

                <h1><a href="{{ action('BlogController@show',$post->id) }}">{{ $post->title }}</a></h1>

                <div class="row mTop10">
                    {!! $post->description !!}
                </div>
            </div>
        </div>

    </div>
    <div class="clear:both"></div>

@endsection
