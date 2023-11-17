<?php

namespace App\Providers;

use App\Models\ContactMs;
use App\Models\OrderAmo;
use App\Models\OrderMs;
use App\Models\Product;
use App\Observers\ContactMsObserver;
use App\Observers\OrderAmoObserver;
use App\Observers\OrderMsObserver;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $observers = [
        OrderMs::class => [OrderMsObserver::class],
        OrderAmo::class=>[OrderAmoObserver::class],
        Product::class=>[ProductObserver::class],
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
//        if(config('app.env') === 'production') {
//            $this->app['request']->server->set('HTTPS', true);
//        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OrderMs::observe(OrderMsObserver::class);
        OrderAmo::observe(OrderAmoObserver::class);
        Product::observe(ProductObserver::class);
        ContactMs::observe(ContactMsObserver::class);

        \URL::forceRootUrl(\Config::get('app.url'));
        if (str_contains(\Config::get('app.url'), 'https://')) {
            \URL::forceScheme('https');
        }

    }
}
