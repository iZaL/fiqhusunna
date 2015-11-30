<div class="panel">
    <div class="panel-heading middle-col-heading">{{ trans('word.latest_articles') }} </div>
    <div class="panel-body">
        @foreach($articles as $article)

            <div class="blogTitle"><a href="{{ action('BlogController@show',$article->id) }}">{{ ucfirst($article->title) }}</a></div>
            <i class="fa fa-calendar"></i>&nbsp; {{ $article->created_at->format('l, M j,Y ') }}

            <div class="row mTop10">
                @if($article->thumbnail)
                    <div class="col-md-3">
                        <a href="{{ action('BlogController@show',$article->id) }}">
                            <img src="/uploads/thumbnail/{{ $article->thumbnail->name}}"
                                 class="img-responsive img-thumbnail">
                        </a>
                    </div>
                    <div class="col-md-9">
                        {!! str_limit($article->description,100) !!}
                    </div>
                @else
                    <div class="col-md-12 article">
                        {!! str_limit(strip_tags($article->description),400) !!}
                    </div>
                @endif

            </div>
            <div class="row">
                <div class="col-md-12 ">
                        <a class="btn btn-default mTop10" href="{{ action('BlogController@show',$article->id) }}">{{ trans('word.more') }}</a>
                    </a>
                </div>
            </div>

            <hr>
        @endforeach
    </div>
    <!--/panel-body-->
</div>
<!--/panel-->

