@extends('layouts.two_col')

@section('title')
    {{ $article->title }}
@endsection

@section('left')
    @include('modules.blog.siderbar-detail',['parentCategories'=>$parentCategories,'selectedCategory'=>$selectedCategory])
@endsection

@section('right')
    <div class="panel">
        <div class="panel-heading blog-title" >{{ ucfirst($article->title) }}</div>
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row article">
                    <div class="meta">
                        <div class="col-md-6">
                            <i class="fa fa-calendar"></i>&nbsp; {{ $article->created_at->format('l, M j,Y ') }}
                        </div>
                        <div class="col-md-6 ">
                            <span class="pull-right">
                                <i class="fa fa-eye"></i>&nbsp; {{ $article->metas->count() }} views
                            </span>
                        </div>
                    </div>
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
