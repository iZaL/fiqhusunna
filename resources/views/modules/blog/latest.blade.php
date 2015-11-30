<div class="panel">
    <div class="panel-heading left-col-heading">{{ trans('word.latest_articles') }} </div>
    <div class="panel-body">
        @foreach($articles as $article)
            <h2><a href="{{ action('BlogController@show',$article->id) }}">{{ $article->title }}</a></h2>

            <div class="row">
                <div class="col-md-3">
                    <a href="{{ action('BlogController@show',$article->id) }}">
                        @if($article->thumbnail)
                            <img src="/uploads/thumbnail/{{ $article->thumbnail->name}}"
                                 class="img-responsive img-thumbnail img-album-thumb">
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
                                href="{{ action('BlogController@show',$article->id) }}">{{ trans('word.more') }}</a></button>
                </div>
            </div>

            <hr>
        @endforeach

    </div>
    <!--/panel-body-->
</div>
<!--/panel-->
