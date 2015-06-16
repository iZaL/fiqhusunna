@extends('layouts.one_col')

@section('title')
    {{ $post->title }}
@endsection

@section('content')

    <div class="panel">
        <div class="panel-heading blog-title" ><h3>{{ $post->title }}</h3></div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row">
                    {!! $post->description !!}
                </div>
            </div>
        </div>

    </div>
    <div class="clear:both"></div>

@endsection
