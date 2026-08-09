<?php

namespace App\Providers;

use App\Models\Aspiration;
use App\Models\Comment;
use App\Models\User;
use App\Observers\AspirationObserver;
use App\Observers\CommentObserver;
use App\Observers\UserObserver;
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
                    $badges['pending_aspirations'] = Aspiration::where('status', 'diajukan')->count();
                } else {
                    $badges['active_aspirations'] = Aspiration::where('user_id', $user->id)
                        ->whereIn('status', ['diajukan', 'diproses'])
                        ->count();
                    $badges['history_aspirations'] = Aspiration::where('user_id', $user->id)
                        ->whereIn('status', ['selesai', 'ditolak'])
                        ->count();
                }
                $view->with('sidebarBadges', $badges);
            }
        });
        Aspiration::observe(AspirationObserver::class);
        Comment::observe(CommentObserver::class);
        User::observe(UserObserver::class);
    }
}
