<?php

namespace InWeb\Admin\TranslatablePhrases;

use InWeb\Admin\App\Admin;
use InWeb\Admin\App\AdminRoute;
use InWeb\Admin\App\Events\ServingAdmin;
use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Admin::serving(function (ServingAdmin $event) {
            Admin::script('translatable-phrases', __DIR__.'/../dist/js/tool.js');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        AdminRoute::api('\InWeb\Admin\TranslatablePhrases\Http\Controllers', function () {
            $this->registerRoutes();
        });
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
