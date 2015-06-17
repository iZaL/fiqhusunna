@extends('admin.layouts.one_col')

@section('title')
    <h1>Edit User {{ $user->name }}</h1>
@stop

@section('style')
    @parent
@stop

@section('script')
    @parent

@stop

@section('content')

    <div class="mTop10">
        {!! Form::model($user,['action' => ['Admin\UserController@update',$user->id], 'files'=>true, 'method' => 'patch'], ['class'=>'form-horizontal']) !!}

        <div class="form-group">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!} <span class="red">*</span>
            {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Name']) !!}
        </div>

        <div class="form-group">
            {!! Form::hidden('isAdmin',0) !!}

            {!! Form::checkbox('isAdmin', $user->isAdmin, ['class' => 'form-control','placeholder'=>'Name']) !!} Admin
        </div>

        <div class="form-group">
            {!! Form::submit('Save Draft', ['class' => 'btn btn-primary form-control']) !!}
        </div>

        {!! Form::close() !!}

    </div>

@stop