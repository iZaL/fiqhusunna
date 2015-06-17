@extends('layouts.one_col')

@section('title')
    {{ $track->name }}
@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            jplayer('{{$track}}', '{{ $trackUrl }}');
        });
    </script>
@endsection

@section('content')

    @if($track->trackeable)
        <div id="bc1" class="btn-group btn-breadcrumb pBottom20">
            <a href="{{url('home')}}" class="btn btn-default"><i class="fa fa-home"></i>&nbsp; </a>
            @if(is_a($track->trackeable, 'Category'))
                <a href="{{action('CategoryController@show',$track->trackeable->id)}}" class="btn btn-default "><i
                            class="fa fa-folder"></i> {{ $track->trackeable->name }}</a>
            @else
                @if($track->trackeable->category)
                    <a href="{{action('CategoryController@show',$track->trackeable->category->id)}}"
                       class="btn btn-default "><i
                                class="fa fa-folder"></i> {{ $track->trackeable->category->name }}</a>

                    <a href="{{action('AlbumController@show',$track->trackeable->id)}}"
                       class="btn btn-default "><i
                                class="fa fa-music"></i> {{ $track->trackeable->name }}</a>

                @endif
            @endif
            <a href="{{action('TrackController@show',$track->id)}}"
               class="btn btn-default "><i
                        class="fa fa-headphones"></i> {{ $track->name }}</a>
        </div>
    @endif

    <h1>{{$track->name}} </h1>
    <div class="col-md-12 pTop10 pBottom10 mTop10" style="background-color: #D8ECF0;">
        <a href="{{ action('TrackController@downloadTrack',$track->id) }}">
            <i class="fa fa-download"></i>
        </a>
        {{ $track->downloads ? $track->downloads->count() : '0' }}
        &nbsp;&nbsp;&nbsp;
        <a href="#">
            <i class="fa fa-eye"></i>
        </a>
        {{ $track->metas ? $track->metas->count() : '0' }}
    </div>
    @include('modules.track.jplayer',['track'=>$track])
@endsection