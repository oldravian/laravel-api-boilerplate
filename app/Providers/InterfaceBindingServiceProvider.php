<?php

namespace App\Providers;

use App\Contracts\Repositories\UserRepositoryInterface;

use App\Repositories\UserRepository;

use Illuminate\Support\ServiceProvider;

class InterfaceBindingServiceProvider extends ServiceProvider
{

    const bindings = [
        UserRepositoryInterface::class => UserRepository::class,
    ];


    /**
     * Register services.
     * @return void
     */
    
    public function register()
    {
        foreach (self::bindings as $key => $binding) {
            $this->app->bind($key, $binding);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
