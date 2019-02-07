<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Nakukryskin\OrchidFlexibleContentField\Commands\LinkCommand;
use Nakukryskin\OrchidFlexibleContentField\Screen\Fields\FlexibleContentField;
use Orchid\Platform\Dashboard;

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
            ->registerProviders()
            ->registerTranslations();

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
        if (!defined('ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH')) {
            define('ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH', realpath(__DIR__.'/../../'));
        }


        if (!defined('ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH')) {
            define('ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH', 'flexible-content-field');
        }

        // Register the service the package provides.
        $this->app->singleton(FlexibleContentField::class, function ($app) {
            return new FlexibleContentField();
        });
    }

    /**
     * Register providers.
     *
     * @return self
     */
    public function registerProviders(): self
    {
        foreach ($this->provides() as $provide) {
            $this->app->register($provide);
        }

        return $this;
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
            ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/public' => public_path(ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH),
        ], 'flexible-content-field.assets');

        // Registering package commands.
        $this->commands([
            LinkCommand::class,
        ]);

        return $this;
    }

    /**
     * Register migrate.
     *
     * @return self
     */
    protected function registerDatabase(): self
    {
        $this->loadMigrationsFrom(realpath(ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/database/migrations'));

        return $this;
    }

    /**
     * Registering resources.
     *
     * @throws \Exception
     * @return self
     */
    private function registerResources(): self
    {
        if (!file_exists(public_path(ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH))) {
            return $this;
        }

        $this->dashboard->registerResource('scripts',
            mix('/js/flexible_content.js', ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH));
        $this->dashboard->registerResource('stylesheets',
            mix('/css/flexible_content.css', ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH));

        return $this;
    }

    /**
     * Registering languages.
     *
     * @return self
     */
    private function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(realpath(ORCHID_FLEXIBLE_CONTENT_PUBLIC_ASSET_PATH.'/resources/lang/'));

        return $this;
    }
}
