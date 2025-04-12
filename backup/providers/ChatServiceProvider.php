<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share unread message count with all views for authenticated users
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $unreadCount = Message::where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
                
                $view->with('unreadMessageCount', $unreadCount);
            }
        });
    }
}
