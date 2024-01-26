<?php

namespace App\Listeners;

use App\Events\ClientCreated;
use App\Notifications\ClientsCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ClientCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ClientCreated $event
     * @return void
     */
    public function handle(ClientCreated $event)
    {
        Notification::route("mail", $this->toEmails())->notify(new ClientsCreated($event->client));
    }

    private function toEmails()
    {
        return [env("SUBMISSIONS_EMAIL_ADDRESS"), env("INFO_EMAIL_ADDRESS")];
    }
}
