<?php

namespace App\Providers;

use App\Events\BlockCreating;
use App\Events\BlockDeleting;
use App\Events\DomainCreated;
use App\Events\SiteCreated;
use App\Events\SiteDeleting;
use App\Listeners\CreateDomainOnHosting;
use App\Listeners\CreateTechnicalDomain;
use App\Listeners\CreateWebServerConfig;
use App\Listeners\DefinePosition;
use App\Listeners\DeleteBlockFiles;
use App\Listeners\DeleteNginxConfigs;
use App\Listeners\DeleteSiteFiles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        BlockCreating::class => [
            DefinePosition::class,
        ],

        BlockDeleting::class => [
            DeleteBlockFiles::class,
        ],

        SiteCreated::class => [
            CreateTechnicalDomain::class,
        ],

        SiteDeleting::class => [
            DeleteSiteFiles::class,
            DeleteNginxConfigs::class,
        ],

        DomainCreated::class => [
            CreateWebServerConfig::class,
            CreateDomainOnHosting::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
