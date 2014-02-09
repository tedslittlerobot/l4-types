<?php namespace Tlr\Types;

use InvalidArgumentException;
use ArrayAccess;

class TypeSet implements ArrayAccess {

	/**
	 * The Content Type Definitions
	 * @var array
	 */
	protected $items = array();

	public function __construct( $config = array() )
	{
		foreach ( $config as $key => $definition )
		{
			$this->add( $key, $definition );
		}
	}

	/**
	 * Get a type by key, or all types
	 * @param  string $key
	 * @return Definition | array
	 */
	public function type( $key = null )
	{
		if ( is_null($key) )
			return $this->items;

		return $this->items[$key];
	}

	/**
	 * Add a new definition
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  string $key
	 * @param  array $definition
	 */
	public function add( $key, $definition )
	{
		if ($definition instanceof Definition)
		{
			$this->items[$key] = $definition;
			return $this;
		}

		if ( is_array( $definition ) )
		{
			$this->items[$key] = new Definition( $definition['name'], $key, $definition['classes'], $definition['views'], $definition['config'] );
			return $this;
		}

		throw new InvalidArgumentException("The second argument ($definition) provided to Tlr\Types\TypeSet@add is not a valid definition");
	}

	/**************************
	 * ARRAY ACCESS INTERFACE *
	 *************************/

	/**
	 * Set content type using array notation
	 * @param  string                   $key
	 * @param  array|Velox\Content\Type\Definition   $definition
	 */
	public function offsetSet ( $key , $definition )
	{
		$this->add( $key, $definition );
	}

	/**
	 * Remove content type using array notation
	 * @param  string   $key
	 */
	public function offsetUnset ( $key )
	{
		array_forget( $this->items, $key );
	}

	/**
	 * Determine whether or not the item is set
	 * @param  string $key
	 * @return boolean
	 */
	public function offsetExists ( $key )
	{
		return isset( $this->items[$key] );
	}

	/**
	 * Retrieve the item
	 * @param  string $key
	 * @return boolean
	 */
	public function offsetGet ( $key )
	{
		return $this->items[$key];
	}

}
