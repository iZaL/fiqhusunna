@extends('admin.layouts.one_col')

@section('title')
    <h1>Add Track</h1>
@stop

@section('style')
    @parent
@stop

@section('script')
    @parent
    <script src="/bower_components/multifile/jquery.MultiFile.js" type="text/javascript"></script>
    <script>
        $(function () {
            $('input.tracks').MultiFile({
                // your options go here
                max: 5,
                accept: 'mp3',
                max_size: 10000, // 10MB
                onFileAppend: function (element, value, master_element) {
//                    $('#F9-Log').append('<li>onFileAppend - ' + value + '</li>')
//                    console.log(element,value,master_element);
                },
            });
        });
    </script>
@stop

@section('content')

    <div class="mTop10">
        {!! Form::open(['action' => 'Admin\TrackController@store', 'method' => 'post', 'files'=>true, 'class'=>'form-horizontal'])
        !!}

        {!! Form::hidden('trackeable_type', $type) !!}
        <div class="form-group">
            {!! Form::label('trackeable_id', $type, ['class' => 'control-label']) !!} <span
                    class="red">*</span>
            {!! Form::select('trackeable_id', $trackeables,null,array('class'=>'form-control')) !!}
        </div>

        <div class="form-group">
            <span class="btn btn-primary fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span class="mBottom10">Select Tracks You want to upload...</span>
                <!-- The file input field used as target for the file upload widget -->
                {!! Form::file('tracks[]', ['multiple' => true,'class' => 'tracks form-control']) !!}
            </span>
        </div>

        <div class="form-group">
            {!! Form::submit('Save Draft', ['class' => 'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}

    </div>

@stop