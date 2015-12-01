@extends('layouts.two_col')

@section('title')
    {{ trans('word.blog') }}
@endsection

@section('left')
    @include('modules.blog.siderbar-detail',['parentCategories'=>$parentCategories,'selectedCategory'=>$selectedCategory])
@endsection
@section('right')
    @include('modules.blog._loop',['articles'=>$articles])
@endsection
