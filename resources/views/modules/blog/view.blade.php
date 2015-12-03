@extends('layouts.two_col')


@section('script')
    @parent
    {{--<script type="text/javascript">var switchTo5x=true;</script>--}}
    {{--<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>--}}
    {{--<script type="text/javascript">stLight.options({publisher: "4dac03e5-453d-4e1f-b7d4-7a907abe45f2", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>--}}
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5660c85eb4c369ce" async="async"></script>

@endsection
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
                    <div class="meta pBottom10">
                        <div class="col-md-6">
                            <i class="fa fa-calendar"></i>&nbsp; {{ $article->created_at->format('l, M j,Y ') }}
                        </div>
                        <div class="col-md-6 ">
                            <span class="pull-right">
                                <i class="fa fa-eye"></i>&nbsp; {{ $article->metas ? $article->metas->count() : '0' }} views
                            </span>
                        </div>
                    </div>
                    @include('partials.social-share-buttons')

                    <hr>
                    {!! $article->description !!}
                    <hr>
                    <div class="authorInfo">
                        author : {{ ucfirst($article->user->name) }}
                    </div>
                    @include('partials.social-share-buttons')
                </div>
            </div>
        </div>

    </div>
    <div class="clear:both"></div>
@endsection
