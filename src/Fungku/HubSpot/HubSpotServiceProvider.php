<?php

namespace Fungku\HubSpot;

use Illuminate\Support\ServiceProvider;

class HubSpotServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('fungku/hubspot');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register 'hubspot' instance container to our HubSpot object
        $this->app['hubspot'] = $this->app->share(function($app)
        {
            return new HubSpot;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('HubSpot', 'Fungku\HubSpot\Facades\HubSpot');
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('hubspot');
	}

}
