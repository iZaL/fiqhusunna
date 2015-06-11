@extends('admin.layouts.one_col')


@section('title')
    <h1>Tracks</h1>
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
                Tracks
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tracks as $track)
                            <tr class="gradeU">
                                <td> {{ $track->name }}</td>
                                <td> {{ $track->trackeable ? $track->trackeable->name : '' }}</td>
                                <td> {{ $track->size }}</td>
                                <td class="center">
                                    <p data-placement="top" data-toggle="tooltip" title="Edit">
                                        <a href={{action('Admin\TrackController@edit',$track->id)}}>
                                            <button class="btn btn-primary btn-xs"><span
                                                        class="glyphicon glyphicon-pencil"></span></button>
                                        </a>
                                    </p>
                                </td>
                                <td class="center">
                                    <p data-placement="top" data-toggle="tooltip" title="Delete">
                                        {!! Form::open(['action' => ['Admin\TrackController@destroy', $track->id], 'method' => 'DELETE'], ['class'=>'form-horizontal']) !!}
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

            <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span
                                        class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are
                                you sure you want to delete this Record?
                            </div>

                        </div>
                        <div class="modal-footer">
                            {!! Form::open(['action' => ['Admin\TrackController@destroy', 1], 'method' => 'delete'],
                            ['class'=>'form-horizontal']) !!}

                            <button type="submit" class="btn btn-success"><span
                                        class="glyphicon glyphicon-ok-sign"></span> Yes
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                        class="glyphicon glyphicon-remove"></span> No
                            </button>

                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </div>
        <!-- /.panel -->
    </div>

@endsection