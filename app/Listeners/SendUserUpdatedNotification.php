<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Mail\UserCreated as UserCreatedMail;
use App\Mail\UserUpdated as UserUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserUpdatedNotification
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
     * @param UserUpdated $event
     * @return void
     */
    public function handle(UserUpdated $event): void
    {
        $attributes = $event->attributes;
        $payload = $event->payload;

        Mail::to($attributes['email'])
            ->queue((new UserUpdatedMail($attributes, $payload))->afterCommit());
    }
}
