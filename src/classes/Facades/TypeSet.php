<?php namespace Tlr\Types\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Events\Dispatcher
 */
class TypeSet extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'content-types'; }

}
