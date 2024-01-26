<?php

namespace App\Listeners;

use App\Events\RelatedPartyCreated;
use App\Notifications\RelatedPartiesCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class RelatedPartyCreatedListener
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
     * @param  RelatedPartyCreated $event
     * @return void
     */
    public function handle(RelatedPartyCreated $event)
    {
        Notification::route("mail", $this->toEmails())->notify(new RelatedPartiesCreated($event->relatedParty));
    }

    private function toEmails()
    {
        return [env("SUBMISSIONS_EMAIL_ADDRESS"), env("INFO_EMAIL_ADDRESS")];
    }
}
