@extends('layouts.one_col')

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <!-- START CONTENT ITEM -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#step1" data-toggle="tab"><b>step 1:</b> Books</a></li>
                <li><a href="#step2" data-toggle="tab"><b>step 2:</b> Published Books</a></li>
                <li><a href="#step3" data-toggle="tab"><b>step 3:</b> Personal Info</a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="step1">
                    <div class="row">
                        <div class="col-xs-12 paddingTop10">
                            <table class="table table-bordered table-order">
                                <thead>
                                <tr>
                                    <th class="hidden-xs">&nbsp;</th>
                                    <th></th>
                                    <th>Total Pages</th>
                                    <th>Status</th>
                                    <th>Last Edited</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td class="hidden-xs"><img src="img/product_01.jpg" width="75"></td>
                                        <td>
                                            <a href="detail.html"> {!! $book->title !!} </a>

                                            <p> {!! \Str::limit(strip_tags($book->body)) !!} </p>
                                        </td>
                                        <td>
                                            <span> {{ $book->meta ? $book->meta->total_pages : 'N/A' }} </span>

                                        </td>
                                        <td>
                                            <span> {{ $book->status }} </span>
                                        </td>
                                        <td>
                                            <span> {{ $book->updated_at->format('Y-m-d') }} </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="step2">
                    <div class="row">
                        <div class="col-xs-12 paddingTop10">
                            Published Books
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="step3">
                    <div class="row">
                        <div class="col-xs-12 paddingTop10">
                            Personal Info
                        </div>
                    </div>
                </div>

            </div>

            <br>

        </div>
        <!-- END CONTENT ITEM -->

    </div>

@stop
