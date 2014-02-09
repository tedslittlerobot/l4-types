<?php namespace Tlr\Types;

class TypesManager {

	protected $typesets = array();

	protected $defaultKey = 'default';

	public function __construct( array $typesets )
	{
		// If the default key is not in the typesets array, use the
		// key of the first typeset
		if ( ! isset($typesets[$this->defaultKey]) )
		{
			$this->defaultKey = reset($typesets);
		}

		// loop and add typesets
		foreach ($typesets as $key => $types)
		{
			$this->addTypeSet( $key, $types );
		}
	}

	/**
	 * Get a type set by key, creating a new one if it does not exist.
	 * Provide no arguments to get the default typeset
	 * @param  string $namespace
	 * @return Tlr\Type\TypeSet
	 */
	public function typeSet( $namespace = null, $config = array() )
	{
		if ( is_null($namespace) )
		{
			return $this->getDefaultTypeSet();
		}

		if ( ! isset($namespace) )
		{
			$this->makeTypeSet( $namespace, $config );
		}

		return $this->typesets[$namespace];
	}

	/**
	 * Make a new typeset with the given key
	 * @param  string $key
	 * @param  array  $types
	 */
	public function addTypeSet( $key, array $types )
	{
		$this->typesets[$key] = new TypeSet( $types );
	}

	/**
	 * Get the default type set key
	 * @return string
	 */
	public function getDefaultTypeSet()
	{
		return $this->typesets[$defaultKey];
	}

	/**
	 * Set the default typeset key
	 */
	public function setDefaultTypeSet( $key )
	{
		if ( isset($this->typesets[$key]) )
		{
			$this->defaultKey = $key;
		}

		throw new \InvalidArgumentsException("The default typeset key cannot be set to `$key`, as no such typeset exists.");
	}

	/**
	 * Return this object
	 * @return Tlr\Types\ContentTypesManager
	 */
	public function getManager()
	{
		return $this;
	}

	/**
	 * Forward the method request to the default typeset object
	 * @param  string $method
	 * @param  array $params
	 * @return mixed
	 */
	public function __call( $method, $params )
	{
		return call_user_func_array( array($this->typeSet(), $method), $parameters );
	}

}
