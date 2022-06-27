<?php

namespace Mohan9a\AdminlteFaq;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AdminLteFaqServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'adminltefaq');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminltefaq');
        
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('adminlte-faq.php'),
            ], 'config');

            if (! class_exists('CreateFaqsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_faqs_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_faqs_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }
            
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('adminltefaq'),
            ], 'assets');

            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('adminltefaq'),
              ], 'assets');

          }

    }

    protected function registerRoutes() {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration() {
        return [
            'prefix' => config('adminlte-faq.prefix'),
            'middleware' => config('adminlte-faq.middleware'),
        ];
    }
}
