@extends('layouts.three_col')

@section('title')
    {{ $track->name }}
@endsection

@section('style')
    @parent
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
    @include('modules.track.jplayer',['track'=>$track])
@endsection