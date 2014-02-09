<?php namespace Tlr\Types;

use InvalidArgumentException;

class Definition {

	protected $name;
	protected $slug;
	protected $classes = array();
	protected $config = array();
	protected $views = array();

	public function __construct( $name, $slug, array $classes, array $views, array $config )
	{
		$this->name = (string) $name;
		$this->slug = (string) $slug;

		$this->classes = (array) $classes;
		$this->views = (array) $views;
		$this->config = (array) $config;
	}

	/**
	 * Represent this object in string form
	 * @return string
	 */
	public function __toString()
	{
		return $this->slug;
	}

	/**
	 * Get a class from the array
	 * @param  string $key
	 * @return string
	 */
	public function classname( $key )
	{
		return $this->classes[ $key ];
	}

	/**
	 * Get a view from the array
	 * @param  string $key
	 * @return string
	 */
	public function view( $key )
	{
		return $this->views[ $key ];
	}

	/**
	 * Get a config item from the array
	 * @param  string $key
	 * @return string
	 */
	public function config( $key )
	{
		return $this->config[ $key ];
	}

	/**
	 * The name of the type
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}

	/**
	 * The name of the type
	 * @return string
	 */
	public function slug()
	{
		return $this->slug;
	}


}
