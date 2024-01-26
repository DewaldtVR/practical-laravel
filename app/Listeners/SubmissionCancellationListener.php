<?php


namespace App\Listeners;


use App\Events\SubmissionCancellationEvent;
use App\Notifications\EvaluationCancellation;
use Illuminate\Support\Facades\Notification;

class SubmissionCancellationListener
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
     * @param SubmissionCancellationEvent $event
     * @return void
     */
    public function handle(SubmissionCancellationEvent $event)
    {
        Notification::route('mail', $this->toEmails())->notify(new EvaluationCancellation($event->evaluation));
    }

    private function toEmails()
    {
        return [env("SUBMISSIONS_EMAIL_ADDRESS")];
    }

}