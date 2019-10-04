<?php

namespace App\Providers;

use App\Http\View\Composers\AdvantagesComposer;
use App\Http\View\Composers\ArticlesComposer;
use App\Http\View\Composers\CategoryComposer;
use App\Http\View\Composers\ClinicComposer;
use App\Http\View\Composers\DoctorsComposer;
use App\Http\View\Composers\MenuComposer;
use App\Http\View\Composers\ServicesComposer;
use App\Http\View\Composers\TestimonialsComposer;
use App\Models\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('locale', App::getLocale());

            $indexPage = Page::whereTranslation('slug', 'index')->first();

            $data = $view->getData();

            if (! isset($data['meta']) or ! is_iterable($data['meta']) or ! isset($data['meta']['title'])) {
                $view->with('meta', ($indexPage and $indexPage->metadata) ? $indexPage->metadata->toArray() : [
                    'title' => config('app.name')
                ]);
            }
        });
    }
}
