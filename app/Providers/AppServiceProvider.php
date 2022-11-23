<?php

namespace App\Providers;

use App\Http\Services\Auth\BasicCompanyAuthorization;
use App\Http\Services\Auth\CompanyAuth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        $this->app->bind(CompanyAuth::class,BasicCompanyAuthorization::class);
    }
}
