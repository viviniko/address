<?php

namespace Viviniko\Address;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Viviniko\Address\Console\Commands\AddressTableCommand;
use Viviniko\Address\Console\CountrySeedCommand;

class AddressServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/address.php' => config_path('address.php'),
        ]);

        // Register commands
        $this->commands('command.address.table');
        $this->commands('command.country.seed');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/address.php', 'address');

        $this->registerRepositories();

        $this->registerAddressService();

        $this->registerCommands();
    }

    public function registerRepositories()
    {
        $this->app->singleton(
            \Viviniko\Address\Repositories\Country\CountryRepository::class,
            \Viviniko\Address\Repositories\Country\EloquentCountry::class
        );
        $this->app->singleton(
            \Viviniko\Address\Repositories\Address\AddressRepository::class,
            \Viviniko\Address\Repositories\Address\EloquentAddress::class
        );
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.address.table', function ($app) {
            return new AddressTableCommand($app['files'], $app['composer']);
        });

        $this->app->singleton('command.country.seed', CountrySeedCommand::class);
    }

    /**
     * Register the favorite service provider.
     *
     * @return void
     */
    protected function registerAddressService()
    {
        $this->app->singleton(
            \Viviniko\Address\Contracts\AddressService::class,
            \Viviniko\Address\Services\AddressService::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            \Viviniko\Address\Contracts\AddressService::class
        ];
    }
}