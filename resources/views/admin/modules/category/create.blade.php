@extends('admin.layouts.one_col')

@section('title')
    <h1>Add a Category</h1>
@stop

@section('style')
    @parent
@stop

@section('script')
    @parent
    <script src="/bower_components/multifile/jquery.MultiFile.js" type="text/javascript"></script>
    <script>
        $(function () {
            $('input.cover').MultiFile({
                // your options go here
                accept: 'jpg|png',
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
        {!! Form::open(['action' => 'Admin\CategoryController@store', 'method' => 'post', 'files'=> true, 'class'=>'form-horizontal']) !!}

        <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!} <span class="red">*</span>
            {!! Form::text('name_ar', null, ['class' => 'form-control','placeholder'=>'Category Name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
            {!! Form::textarea('description_ar', null, ['class' => 'form-control editor','placeholder'=>'Category Description']) !!}
        </div>

        <div class="form-group">
            <span class="btn btn-default fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select Cover Image...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="cover" type="file" name="cover" class="cover form-control">
            </span>
        </div>

        <div class="form-group">
            {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}

    </div>

@stop