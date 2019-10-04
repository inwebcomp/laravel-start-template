<?php

namespace App\Providers;

use InWeb\Admin\App\Admin;
use InWeb\Admin\App\Events\ServingAdmin;
use InWeb\Admin\App\Providers\AdminApplicationServiceProvider;
use InWeb\Admin\TranslatablePhrases\TranslatablePhrases;

class AdminServiceProvider extends AdminApplicationServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Admin::serving(function (ServingAdmin $event) {
            \App::setLocale('ru');
        });

        Admin::auth(function() {
            return auth()->user();
        });
    }

    public function groups()
    {
        parent::groups();
    }

    /**
     * Register the application's Admin resources.
     *
     * @return void
     */
    protected function resources()
    {
        Admin::resourcesIn(app_path('Admin/Resources'));
    }

    /**
     * Get the cards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new TranslatablePhrases()
        ];
    }
}
