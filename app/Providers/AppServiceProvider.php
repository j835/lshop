<?php

namespace App\Providers;

use App\Services\Facades\BreadcrumbService;
use App\Services\Facades\CartService;
use App\Services\Facades\SeoService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Breadcrumb' , BreadcrumbService::class);
        $this->app->bind("Cart", CartService::class);
        $this->app->singleton('Seo', SeoService::class);
        $this->app->bind('ProductService', ProductService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            $recaptcha = new ReCaptcha(config('app.recaptcha_secret_key'));
            $resp = $recaptcha->verify($value, request()->ip());

            return $resp->isSuccess();
        });

        \Validator::extend('code', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-z0-9-_]+$/', $value);
        });

        \Validator::extend('price', function ($attribute, $value, $parameters, $validator) {
            return (float)$value > 0.01;
        });
    }
}
