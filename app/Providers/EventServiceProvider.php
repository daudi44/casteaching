<?php

namespace App\Providers;

use App\Console\Commands\TestSendVideoCreatedEmail;
use App\Events\SeriesImageUpdated;
use App\Listeners\SendVideoCreatedNotification;
use App\Events\VideoCreated;
use App\Listeners\ScheduleSeriesImageProcessing;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        VideoCreated::class => [
            SendVideoCreatedNotification::class,
        ],
        SeriesImageUpdated::class => [
            ScheduleSeriesImageProcessing::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
