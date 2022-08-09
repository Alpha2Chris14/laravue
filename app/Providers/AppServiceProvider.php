<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
// use Laravel\Passport\Passport;

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
        //
        // Passport::routes(function($router){
        //     $router->forAccessTokens();
        // });

        $this->authorization("isAdmin","administrator");
        $this->authorization("isUser","user");
        $this->authorization("isRegular","regular");
    }

    private function authorization($check,$value){
        Gate::define($check,function(User $user) use ($value){
            return $user->role === $value;
        });
    }
}
