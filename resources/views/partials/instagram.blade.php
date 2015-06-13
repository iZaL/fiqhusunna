@foreach($instas as $insta)
        @if($insta->type='image')
            <div class="col-md-3 col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <img src="{{$insta->images->low_resolution->url}}" class="img-responsive">
                    </div>
                </div>
            </div>
        @endif
@endforeach
