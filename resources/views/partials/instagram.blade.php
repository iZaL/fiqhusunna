@foreach($instas as $insta)
    @if($insta->type='image')
        <div class="col-md-4 col-sm-4 col-xs-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="{{ $insta->link }}" target="_blank"><img src="{{$insta->images->low_resolution->url}}"
                                                                      class="img-responsive"></a>
                </div>
            </div>
        </div>
    @endif
@endforeach
