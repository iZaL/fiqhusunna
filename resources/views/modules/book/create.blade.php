@extends('layouts.one_col')

@section('title')
    <h1>Publish Your Book</h1>
@stop

@section('style')
    @parent
@stop

@section('script')
    @parent
    <script src="/vendor/tinymce/tinymce.jquery.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea.editor",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor jbimages directionality"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages | print preview media fullpage | forecolor backcolor emoticons | ltr rtl ",
            relative_urls: false
        });
    </script>
@stop

@section('content')

    {!! Form::open(['action' => 'BookController@store', 'method' => 'post'], ['class'=>'form-horizontal']) !!}

    <div class="form-group ">
        {!! Form::label('free', 'Free Book ?:') !!}
        {!! Form::hidden('free', 0) !!}
        {!! Form::checkbox('free', 1, false) !!}
    </div>
    <div class="form-group">
        {!! Form::label('title_en', 'Title In English', ['class' => 'control-label']) !!}
        {!! Form::text('title_en', null, ['class' => 'form-control','placeholder'=>'Book Title in English']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('title_en', 'Title In Arabic', ['class' => 'control-label']) !!}
        {!! Form::text('title_ar', null, ['class' => 'form-control','placeholder'=>'Book Title in Arabic']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('body', 'Book Content', ['class' => 'control-label']) !!}
        {!! Form::textarea('body', null, ['class' => 'form-control editor','placeholder'=>'Book Content']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Save Draft', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@stop