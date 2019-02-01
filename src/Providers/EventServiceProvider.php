<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nakukryskin\OrchidFlexibleContentField\Observers\FlexibleContentObserver;
use Orchid\Press\Models\Post;

/**
 * Class EventServiceProvider
 * @package Nakukryskin\OrchidFlexibleContentField\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();

        Post::observe(FlexibleContentObserver::class);
    }
}
