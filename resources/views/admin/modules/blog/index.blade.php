@extends('admin.layouts.one_col')

@section('title')
    <h1>Blog Posts</h1>
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
                Blog Posts
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($blogs as $blog)
                            <tr class="gradeU">
                                <td> {{ $blog->title }}</td>

                                <td>
                                    <a href="{{ action('Admin\BlogController@edit',$blog->id)  }}"
                                       class="btn btn-sm btn-primary" role="button">Edit</a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModalBox"
                                            data-link="{{action('Admin\BlogController@destroy',$blog->id)}}">Delete
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
                @include('admin.partials.delete-modal',['info' => 'Delete Article '.$blog->title. ' ?'])

            </div>
            <!-- /.panel-body -->

        </div>
        <!-- /.panel -->
    </div>

@endsection