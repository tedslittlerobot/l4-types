<?php namespace Tlr\Types;

use Illuminate\Support\ServiceProvider;
use Tlr\Types\TypesManager;

class TypeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Kick off the router using events
	 */
	public function boot()
	{
		$this->package('tlr/l4-types');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['content-types'] = $this->app->bindShared(function()
		{
			$default = $this->app['config']->get('types.default');
			$types = array_get( $this->app['config']->get('types.types') );

			return new TypesManager( $default, $types );
		});
	}

}
