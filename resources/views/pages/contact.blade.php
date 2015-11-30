@extends('layouts.one_col')

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="row">
                <div class="col-xs-12 col-sm-6">

                    <!-- START CONTENT ITEM -->
                    {!! Form::open(['url' => '/contact', 'method' => 'post', 'class'=>'form-horizontal'])  !!}
                    <fieldset>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_01">{{ucfirst(trans('word.name'))}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <input type="text" class="form-control" name="name" id="name">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_03">{{ucfirst(trans('word.email'))}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <input type="text" class="form-control" name="email" id="email">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_02">{{ucfirst(trans('word.phone'))}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <input type="text" class="form-control" name="phone" id="phone">

                                <p class="help-block">##-###-#####</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_05">{{ucfirst(trans('word.comment'))}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <textarea class="form-control" rows="5" name="body" id="body"></textarea>

                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary col-md-12">{{trans('word.send')}} <i
                                        class="icon-chevron-right icon-white"></i>
                            </button>
                        </div>
                    </fieldset>
                    {!! Form::close()!!}
                            <!-- END CONTENT ITEM -->

                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="well">

                        <!-- START CONTENT ITEM -->
                        <address>
                            <strong>Fiqhussunna.com</strong><br>
                            <br>
                            <i class="fa fa-google"></i>
                            pnabdurahman@gmail.com
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-4 col-xs-12">
                                    <div class="col-md-1 col-xs-4 "><a href="https://twitter.com/pnabdurahman"><i
                                                    class="fa fa-twitter "></i></a></div>
                                    <div class="col-md-1 col-xs-4 "><a href="https://www.youtube.com/channel/UCwq7He3Ulzukp5LXwzbWGfw"><i
                                                    class="fa fa-youtube "></i></a></div>
                                    <div class="col-md-1 col-xs-4 "><a href="http://facebook.com/"><i
                                                    class="fa fa-facebook "></i></a></div>
                                </div>
                                <div class="col-md-8 col-xs-12">

                                </div>
                            </div>
                        </address>
                        <!-- END CONTENT ITEM -->

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
