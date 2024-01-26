<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\EvaluationStateUpdated' => [
            'App\Listeners\EvaluationStateUpdatedListener',
        ],
        'App\Events\CompanyCreated' => [
            'App\Listeners\CompanyCreatedListener',
        ],
        'App\Events\SubmissionCreated' => [
            'App\Listeners\SubmissionCreatedListener',
        ],
        'App\Events\UserCreatedEvent' => [
            'App\Listeners\UserCreatedListener',
        ],
        'App\Events\SubmissionCancellationEvent' => [
            'App\Listeners\SubmissionCancellationListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
