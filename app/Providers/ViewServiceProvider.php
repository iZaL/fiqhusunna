<?php

namespace App\Providers;

use App\Http\Composers\ArticleCategory;
use App\Http\Composers\TrackCategory;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.track-category-menu', 'App\Http\Composers\TrackCategory');
        view()->composer('partials.article-category-menu', 'App\Http\Composers\ArticleCategory');
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register()
    {

    }

}
