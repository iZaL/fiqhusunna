<nav class="navbar navbar-static">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('home') }}"><i class="fa fa-home"></i><b> {{ trans('word.home') }}</b></a>
            <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <i class="fa fa-chevron-down"></i>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ action('BlogController@index') }}">{{ trans('word.blog') }}</a></li>
                <li><a href="{{ action('PageController@getAbout') }}">{{ trans('word.about_us') }}</a></li>
                <li><a href="{{ action('PageController@getContact') }}">{{ trans('word.contact_us') }}</a></li>
            </ul>
        </div>
    </div>
</nav>