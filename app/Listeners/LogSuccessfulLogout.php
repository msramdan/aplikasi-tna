<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {
        $user = $event->user;
        $userAgent = request()->header('User-Agent');
        $ipAddress = request()->ip();

        $attributes = [
            'email' => $user->email,
            'name' => $user->name,
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
        ];

        activity('log_auth')
            ->performedOn($user)
            ->causedBy($user)
            ->event('Logout')
            ->withProperties(['attributes' => $attributes])
            ->log("User {$user->name} berhasil logout");
    }
}
