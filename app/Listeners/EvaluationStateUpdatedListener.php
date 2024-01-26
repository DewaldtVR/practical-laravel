<?php

namespace App\Listeners;

use App\Events\EvaluationStateUpdated;
use App\Notifications\EvaluationStateChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EvaluationStateUpdatedListener
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
     * @param  EvaluationStateUpdated  $event
     * @return void
     */
    public function handle(EvaluationStateUpdated $event)
    {
        $user = $event->evaluation->user;
        $event->evaluation->load("file");
        $user->notify(new EvaluationStateChanged($event->evaluation));
    }
}
