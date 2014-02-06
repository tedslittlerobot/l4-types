<?php namespace Tlr\Types;
<?php namespace Velox\Content\Type;

use InvalidArgumentException;
use Velox\Core\Content;

class Definition {

	protected static $_classes = [
		'model',
		'repository',
	];

	protected static $_views = array(
		'fields',
	);

	protected $name;
	protected $slug;
	protected $classes = array();
	protected $config = array();
	protected $views = array();

	public function __construct( $app, $name, $slug, array $classes, array $views, array $config )
	{
		$this->app = $app;

		$this->name = (string) $name;
		$this->slug = (string) $slug;

		$this->classes = $classes;
		$this->views = $views;
		$this->config = $config;

		foreach( static::$_classes as $name )
		{
			if (!isset($this->classes[$name]))
			{
				throw new InvalidArgumentException("Content Type Definition for '{$this->name}' must have a class defined for key '$name'");
			}
		}

		foreach( static::$_views as $name )
		{
			if (!isset($this->views[$name]))
			{
				throw new InvalidArgumentException("Content Type Definition for '{$this->name}' must have a view defined for key '$name'");
			}
		}

	}

	/**
	 * Start a new query for content of this type
	 * @return Illuminate\Database\Eloquent\Builder
	 */
	public function query()
	{
		return Content::where( 'type', $this->model );
	}

	/**
	 * Represent this object in string form
	 * @return string
	 */
	public function __toString()
	{
		return json_encode($this);
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
	 * Resolve a class
	 * @param  string $key
	 * @return string
	 */
	public function resolve( $key )
	{
		return $this->app->make( $this->classname( $key ) );
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
	 * The model class
	 * @return string
	 */
	public function model()
	{
		return $this->resolve('model');
	}

	/**
	 * The model class
	 * @return string
	 */
	public function type()
	{
		return $this->classname('model');
	}

	/**
	 * The repository class
	 * @return string
	 */
	public function repository()
	{
		return $this->resolve('repository');
	}

	/**
	 * The fields view identifier
	 * @return string
	 */
	public function fields()
	{
		return $this->view('fields');
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
