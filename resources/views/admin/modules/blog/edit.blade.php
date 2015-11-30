@extends('admin.layouts.one_col')

@section('title')
    <h1>Edit Blog Post {{ $blog->title }}</h1>
@stop

@section('style')
    @parent
@stop

@section('script')
    @parent

@stop

@section('content')

    <div class="mTop10">
        {!! Form::model($blog,['action' => ['Admin\BlogController@update',$blog->id], 'method' => 'patch'], ['class'=>'form-horizontal']) !!}


        <div class="form-group">
            {!! Form::label('parent_id', 'Category', ['class' => 'control-label']) !!} <span class="red">*</span>
            <select name="category_id" class="form-control">
                <option value="">choose a category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}"
                        @if($category->id == Form::getValueAttribute('category_id') )
                            selected="selected"
                        @endif
                        >
                    >{{$category->name}}</option>
                    @foreach($category->childCategories as $child)
                        <option value="{{ $child->id }}"
                                @if($category->id == Form::getValueAttribute('category_id') )
                                selected="selected"
                                @endif
                        >-- {{$child->name}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>

        <div class="form-group">
            {!! Form::label('title', 'Article Title in English', ['class' => 'control-label']) !!} <span class="red">*</span>
            {!! Form::text('title_en', null, ['class' => 'form-control','placeholder'=>'Category Name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('title', 'Article Title in Arabic', ['class' => 'control-label']) !!} <span class="red">*</span>
            {!! Form::text('title_ar', null, ['class' => 'form-control','placeholder'=>'Category Name']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'English Article', ['class' => 'control-label']) !!}
            {!! Form::textarea('description_en', null, ['class' => 'form-control editor','placeholder'=>'Category
            Description']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', 'Arabic Article', ['class' => 'control-label']) !!}
            {!! Form::textarea('description_ar', null, ['class' => 'form-control editor','placeholder'=>'Category
            Description']) !!}
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
            {!! Form::submit('Save Draft', ['class' => 'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}

        @include('admin.modules.photo._delete',['record' => $blog])

    </div>

@stop