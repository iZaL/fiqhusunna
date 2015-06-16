@foreach($instas as $insta)
        @if($insta->type='image')
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="{{ $insta->link }}" target="_blank"><img src="{{$insta->images->low_resolution->url}}" class="img-responsive"></a>
                    </div>
                </div>
            </div>
        @endif
@endforeach
