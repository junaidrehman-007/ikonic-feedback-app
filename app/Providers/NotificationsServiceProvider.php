<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (auth()->check()) {
            $user = auth()->user();
            dd($user);
            $notifications = $user->notifications;
    
            // Share the $notifications variable with all views
            View::share('notifications', $notifications);
        }
    }
}
