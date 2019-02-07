<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Providers;

use Orchid\Press\Models\Page;
use Orchid\Press\Models\Post;
use Orchid\Platform\Dashboard;
use Nakukryskin\OrchidFlexibleContentField\Observers\FlexibleContentObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider.
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

        Dashboard::modelClass(Post::class)::observe(FlexibleContentObserver::class);
        Dashboard::modelClass(Page::class)::observe(FlexibleContentObserver::class);
    }
}
