<?php namespace Velox\Content;

use Illuminate\Routing\Router;
use Illuminate\Events\Dispatcher;

class RouteDispatcher {

	public function contentDisplayRoutes($velox, $router)
	{
		$router->get('/', ['as' => 'home', 'uses' => 'Velox\Content\DisplayController@archive']);
		$router->get('{type}', ['as' => 'type', 'uses' => 'Velox\Content\DisplayController@type']);
		$router->get('{type}/{content_slug}', ['as' => 'content', 'uses' => 'Velox\Content\DisplayController@content']);
	}

	public function contentAdminRoutes($velox, $router)
	{
		/**
		 * @todo admin routes for cotent types
		 *
		 * within each content type, there should be a content resource controller should have an index, create, edit, preview and delete
		 */
		$router->get( 'content', [ 'as' => 'admin.content.types', 'uses' => 'Velox\Content\AdminController@types' ] );
		$router->group( [ 'prefix' => 'content/{type}' ] , function() use ($router)
		{
			$router->get( '/', [ 'as' => 'admin.content.index', 'uses' => 'Velox\Content\AdminController@index' ] );
			$router->get( 'create', [ 'as' => 'admin.content.create', 'uses' => 'Velox\Content\AdminController@create' ] );
			$router->post( 'create', [ 'as' => 'admin.content.store', 'uses' => 'Velox\Content\AdminController@store' ] );
			$router->get( '{content_id}', [ 'as' => 'admin.content.show', 'uses' => 'Velox\Content\AdminController@show' ] );
			$router->get( '{content_id}/edit', [ 'as' => 'admin.content.edit', 'uses' => 'Velox\Content\AdminController@edit' ] );
			$router->put( '{content_id}', [ 'as' => 'admin.content.update', 'uses' => 'Velox\Content\AdminController@update' ] );
			$router->delete( '{content_id}/delete', [ 'as' => 'admin.content.delete', 'uses' => 'Velox\Content\AdminController@softDelete' ] );
			$router->get( '{content_id}/destroy', [ 'as' => 'admin.content.destroy.confirm', 'uses' => 'Velox\Content\AdminController@confirmDestruction' ] );
			$router->delete( '{content_id}/destroy', [ 'as' => 'admin.content.destroy', 'uses' => 'Velox\Content\AdminController@destroy' ] );
		});
	}

}
