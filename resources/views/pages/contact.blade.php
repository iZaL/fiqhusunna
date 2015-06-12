@extends('layouts.one_col')

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="row">
                <div class="col-xs-12">
                    <!-- START CONTENT ITEM -->
                    <h1 style="text-align: center">{{ trans('word.contact_us') }}</h1>
                    <hr>
                    <!-- END CONTENT ITEM -->
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6">

                    <!-- START CONTENT ITEM -->
                    {!! Form::open(['url' => '/contact', 'method' => 'post', 'class'=>'form-horizontal'])  !!}
                    <fieldset>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_01">{{trans('word.name')}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <input type="text" class="form-control" name="name" id="name">

                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_03">{{trans('word.email')}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <input type="text" class="form-control" name="email" id="email">

                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_02">{{trans('word.phone')}}</label>

                            <div class="col-xs-12 col-sm-8">
                                <input type="text" class="form-control" name="phone" id="phone">

                                <p class="help-block">##-###-#####</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-4 control-label"
                                   for="field_05">{{trans('word.comments')}}</label>

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
                            <strong>CompanyName</strong><br>
                            Address 123<br>
                            Zipcode, State, City<br>
                            Optional country name<br>
                            <br>
                            012-345 67 89<br>
                            info@example.com<br>
                        </address>
                        <div class="googlemap">
                            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0"
                                    src="https://maps.google.com/?ie=UTF8&amp;ll=42.065607,-77.189941&amp;spn=15.324445,23.620605&amp;t=m&amp;z=6&amp;output=embed"></iframe>
                        </div>
                        <!-- END CONTENT ITEM -->

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
