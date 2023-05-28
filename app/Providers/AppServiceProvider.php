<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $objValidator = new Validator();
        $objValidator::extend('cpf', '\App\Utils\CpfValidation@validate');
        $objValidator::extend('cnpj', '\App\Utils\CnpjValidation@validate');
    }
}
