<?php

namespace Drewlabs\Laravel\Memory\Usage;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $this->app->bind(Middleware::class, function() {
            return new Middleware(function($log) {
                Event::dispatch($log);
            });
        });
    }

}