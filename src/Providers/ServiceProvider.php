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
     * Required version of orchid/platform package.
     */
    const REQUIRED_ORCHID_PLATFORM_VERSION = '3.8.1';
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

        $this->versionCompare()
            ->registerResources()
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
        $this->dashboard->addPublicDirectory('flexible_content', ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/public/');

        \View::composer('platform::layouts.app', function () {
            \Dashboard::registerResource('scripts', orchid_mix('/js/flexible_content.js', 'flexible_content'))
                ->registerResource('stylesheets', orchid_mix('/css/flexible_content.css', 'flexible_content'));
        });

        return $this;
    }

    /**
     * Registering languages.
     *
     * @return self
     */
    private function registerTranslations(): self
    {
        $this->loadJsonTranslationsFrom(realpath(ORCHID_FLEXIBLE_CONTENT_FIELD_PACKAGE_PATH.'/resources/lang/'));

        return $this;
    }

    /**
     * Check that the package has correct orchid platform version.
     * @throws \Exception
     */
    private function versionCompare()
    {
        if (!version_compare(\Dashboard::version(), self::REQUIRED_ORCHID_PLATFORM_VERSION, '>=')) {
            throw new \Exception(sprintf(__('You cannot install %1$s because %1$s requires orchid/platform version %2$s or higher. You are running orchid/platform version %3$s.'),
                self::class, self::REQUIRED_ORCHID_PLATFORM_VERSION, \Orchid\Platform\Dashboard::VERSION));
        }

        return $this;
    }
}
