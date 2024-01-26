<?php

namespace App\Listeners;

use App\Events\SubmissionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SubmissionCreatedListener
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
     * @param SubmissionCreated $event
     * @return void
     */
    public function handle(SubmissionCreated $event)
    {
        Notification::route("mail", $this->toEmails())->notify(new \App\Notifications\SubmissionCreated($event->evaluation));
    }

    private function toEmails(){
        return[env("SUBMISSIONS_EMAIL_ADDRESS")];
    }

}
