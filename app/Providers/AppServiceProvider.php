<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Documentaciones;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(
          'App\Repositories\RepositoryInterface',
          'App\Repositories\BaseRepository'       
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      //  Schema::defaultStringLength(191);   
        
        view()->composer('*', function($view) {
            $view->with('documentos', Documentaciones::all());
        });
        
    }
}
