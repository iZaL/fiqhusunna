@extends('admin.layouts.one_col')

@section('title')
    <h1>Users</h1>
@endsection

@section('style')
    @parent
@endsection

@section('script')
    @parent
@endsection

@section('content')
    <div class="col-lg-12 mTop10">
        <div class="panel panel-default">
            <div class="panel-heading">
                Users
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="gradeU">
                                <td> {{ $user->name }}</td>
                                <td> {{ $user->email  }}</td>
                                <td> {{ $user->isAdmin ? 'true' : 'false' }}</td>
                                <td class="center">
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href={{action('Admin\UserController@edit',$user->id)}}>
                                            <button class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-pencil"></span></button>
                                        </a>
                                    </p>
                                </td>
                                <td class="center">
                                    <p data-placement="top" data-toggle="tooltip" title="Delete">
                                        {!! Form::open(['action' => ['Admin\UserController@destroy', $user->id], 'method' => 'DELETE'], ['class'=>'form-horizontal']) !!}
                                        {!! Form::submit('delete', ['class' => 'btn btn-danger btn-xs']) !!}
                                        {!! Form::close() !!}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->

            </div>
            <!-- /.panel-body -->


        </div>
        <!-- /.panel -->
    </div>

@endsection