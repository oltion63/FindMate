<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'notifications' => function () {
                $userId = auth()->id();

                if (!$userId) {
                    return [];
                }

                // Query notifications table where user_id = auth()->id()
                return DB::table('notifications')
                    ->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get(['id', 'message', 'created_at'])
                    ->map(function ($notification) {
                        return [
                            'id' => $notification->id,
                            'message' => $notification->message,
                            'created_at' => \Carbon\Carbon::parse($notification->created_at)->diffForHumans(),
                        ];
                    });
            }
        ]);
    }
}
