<nav class="navbar navbar-static">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('home') }}"><i class="fa fa-home"></i><b> {{ trans('word.home') }}</b></a>
            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="glyphicon glyphicon-chevron-down"></span>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="#">{{ trans('word.about_us') }}</a></li>
                <li><a href="#">{{ trans('word.contact_us') }}</a></li>
            </ul>
        </div>
    </div>
</nav>