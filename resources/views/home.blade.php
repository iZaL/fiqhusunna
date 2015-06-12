@extends('layouts.three_col')

@section('banner')
    {{--@include('partials.instagram')--}}
@endsection

@section('right')
    @include('modules.category.sidebar')
@endsection

@section('left')
    @include('modules.blog.sidebar')
@endsection

@section('script')
    @parent
    <script>

    </script>
@endsection

@section('middle')

    <div class="panel" id="midCol">
        <div class="panel-heading middle-col-heading">{{ trans('word.latest_tracks') }}</div>
        <div class="panel-body">

            <ul class="list-group">
                @foreach($tracks as $track)
                    <h5>
                        <li class="list-group-item">
                            <a href="{{ action('TrackController@show',$track->id) }}"><i
                                        class="fa fa-music track" data-id="{{$track->id}}"></i> {{ $track->name }}</a>
                        </li>
                    </h5>
                @endforeach
            </ul>

        </div>
    </div>
@endsection
