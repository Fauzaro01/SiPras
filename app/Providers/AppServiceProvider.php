<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        view()->composer('layouts.dashboard', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $badges = [];
                if ($user->isAdmin()) {
                    $badges['pending_aspirations'] = \App\Models\Aspiration::where('status', 'diajukan')->count();
                } else {
                    $badges['active_aspirations'] = \App\Models\Aspiration::where('user_id', $user->id)
                        ->whereIn('status', ['diajukan', 'diproses'])
                        ->count();
                    $badges['history_aspirations'] = \App\Models\Aspiration::where('user_id', $user->id)
                        ->whereIn('status', ['selesai', 'ditolak'])
                        ->count();
                }
                $view->with('sidebarBadges', $badges);
            }
        });
        \App\Models\Aspiration::observe(\App\Observers\AspirationObserver::class);
        \App\Models\Comment::observe(\App\Observers\CommentObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
    }
}
