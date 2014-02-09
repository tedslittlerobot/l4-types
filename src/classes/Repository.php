<?php namespace Tlr\Types;

use Tlr\Support\Repository as Repo;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class Repository extends Repo {

	protected $rules = array(
		'title' => 'required',
		'slug' => 'required',
	);

	/**
	 * The related content type model
	 * @var Velox\Content\Type\Model
	 */
	protected $related;

	/**
	 * The definition
	 * @var Velox\Content\Type\Definition
	 */
	protected $definition;

	/**
	 * The Related Model's Repository
	 * @var Velox\Content\Type\RepositoryInterface
	 */
	protected $repository;

	public function __construct( Content $content )
	{
		$this->input = Input::all();
		$this->model = $content;
	}

	/**
	 * Get or set the type definition
	 * @param  Velox\Content\Type\Definition     $definition
	 * @return mixed
	 */
	public function type( Definition $definition = null )
	{
		if ( is_null($definition) )
		{
			return $this->definition;
		}

		$this->definition = $definition;

		return $this;
	}

	/**
	 * Get the repository object
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return RepositoryInterface
	 */
	public function getRepository()
	{
		if ( is_null($this->repository) )
		{
			$this->repository = App::make( $this->definition->classname('repository') );
		}

		return $this->repository;
	}

	/**
	 * Create a new content
	 * @return Velox\Content\Content
	 */
	public function create()
	{
		if ( ! $this->validate() )
			return null;

		$this->related = $this->type()->model();

		$this->fill();

		DB::transaction(function()
		{
			$this->related = $this->getRepository()->create( $this->related, $this->data(), $this->file() );
			$this->related->parent()->save($this->model);
		});

		return $this->model;
	}

	/**
	 * Create a new content
	 * @return Velox\Content\Content
	 */
	public function update( Content $content )
	{
		if ( ! $this->validate() )
			return null;

		$this->model = $content;
		$this->related = $this->model->content;

		$this->fill();
		// $this->fill()->repository->update();

		return $this->model;
	}

	/**
	 * Validate both models
	 * @return boolean
	 */
	public function validate()
	{
		$valPasses = parent::validate();

		$relatedValPasses = $this->getRepository()->validate();

		if ( $valPasses && $relatedValPasses )
			return true;

		return false;
	}

	/**
	 * Return the merged errors from the content and related models
	 * @return Illuminate\Support\MessageBag
	 */
	public function getErrors()
	{
		return $this->val->getMessageBag()->merge( $this->getRepository()->getErrors()->toArray() );
	}

}
