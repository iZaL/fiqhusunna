@if(count($record->photos))
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped custab">
                <thead>
                <a href="#" class="btn btn-primary btn-xs"> Delete Photos </a>
                <tr>
                    <th>Image</th>
                    <th class="text-center">Action</th>
                </tr>
                @foreach($record->photos as $photo)
                    <tr>
                        <td> {!! Html::image('/uploads/thumbnail/'.$photo->name.'','image1',array('class'=>'img-responsive img-thumbnail')) !!} </td>
                        <td>
                            {!! Form::open(['action' => ['Admin\PhotoController@destroy', $photo->id], 'method' => 'DELETE', 'class'=>'form-horizontal']) !!}
                            {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>

                @endforeach
            </table>
        </div>
    </div>
@endif