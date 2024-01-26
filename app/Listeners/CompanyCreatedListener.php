<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use App\Notifications\OrganisationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CompanyCreatedListener
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
     * @param CompanyCreated $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        Notification::route("mail", $this->toEmails())->notify(new OrganisationCreated($event->company));
    }

    private function toEmails()
    {
        return [env("SUBMISSIONS_EMAIL_ADDRESS"), env("INFO_EMAIL_ADDRESS")];
    }
}
