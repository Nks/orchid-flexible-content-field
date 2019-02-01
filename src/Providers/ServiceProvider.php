<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Providers;

use Orchid\Platform\Dashboard;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Nakukryskin\OrchidFlexibleContentField\Screen\Fields\FlexibleContentField;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Perform post-registration booting of services.
     *
     * @param Dashboard $dashboard
     * @return void
     * @throws \Exception
     */
    public function boot(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;

        $this->registerResources()
            ->registerDatabase()
            ->registerProviders();

        $this->loadViewsFrom(ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/resources/views', 'platform');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH')) {
            define('ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH', realpath(__DIR__.'/../../'));
        }

        // Register the service the package provides.
        $this->app->singleton(FlexibleContentField::class, function ($app) {
            return new FlexibleContentField();
        });
    }

    /**
     * Register providers.
     */
    public function registerProviders(): void
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            EventServiceProvider::class,
        ];
    }

    /**
     * Console-specific booting.
     *
     * @return self
     */
    protected function bootForConsole()
    {
        // Publishing the views.
        $this->publishes([
            ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/resources/views' => base_path('resources/views/vendor/platform'),
        ], 'platform');

        // Publishing assets.
        $this->publishes([
            ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/resources/public' => public_path('vendor/platform/flexible-content-field'),
        ], 'flexible-content-field.assets');

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase()
    {
        $this->loadMigrationsFrom(realpath(ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/database/migrations'));

        return $this;
    }

    /**
     * Registering resources.
     *
     * @throws \Exception
     */
    private function registerResources(): self
    {
        if (! file_exists(public_path('vendor/platform/flexible-content-field'))) {
            return $this;
        }

        $this->dashboard->registerResource('scripts',
            mix('/js/flexible_content.js', 'vendor/platform/flexible-content-field'));
        $this->dashboard->registerResource('stylesheets',
            mix('/css/flexible_content.css', 'vendor/platform/flexible-content-field'));

        return $this;
    }
}
