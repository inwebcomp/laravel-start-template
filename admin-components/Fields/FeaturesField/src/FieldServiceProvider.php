<?php

namespace Admin\Fields\FeaturesField;

use Illuminate\Support\ServiceProvider;
use InWeb\Admin\App\Admin;
use InWeb\Admin\App\Events\ServingAdmin;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Admin::serving(function (ServingAdmin $event) {
            Admin::script('features-field', __DIR__.'/../dist/js/field.js');
            Admin::style('features-field', __DIR__.'/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
