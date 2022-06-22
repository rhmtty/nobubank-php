<?php

namespace ZerosDev\NobuBank\Laravel;

use ZerosDev\NobuBank\Client;
use ZerosDev\NobuBank\Constant;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            $mode = (string) config('nobu_bank.mode');
            $config = (array) config('nobu_bank.'.$mode);
            return new Client($mode, $config);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/laravel.php' => config_path('nobu_bank.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class];
    }
}