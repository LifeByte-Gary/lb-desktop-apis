<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\UserCreated as UserCreatedMail;
use Illuminate\Support\Facades\Mail;

class SendUserCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;
        $password = $event->password;

        Mail::to($user->email)->send(new UserCreatedMail($user, $password));
    }
}
