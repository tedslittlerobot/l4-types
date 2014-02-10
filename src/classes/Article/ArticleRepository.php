<?php namespace Tlr\Types\Article;

use Tlr\Support\Repository as Repository;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;

class ArticleRepository extends Repository {

	protected $rules = array(
		'body' => 'required',
	);

	/**
	 * The Related Model's Repository
	 * @var Tlr\Types\RepositoryInterface
	 */
	protected $repository;

	public function __construct( Article $article )
	{
		$this->input = Input::all();
		$this->model = $article;
	}

	/**
	 * Create a new content
	 * @return Velox\Content\Content
	 */
	public function create()
	{
		if ( ! $this->validate() )
		{
			return null;
		}

		$this->fill();
		$this->save();

		return $this->model;
	}

	/**
	 * Create a new content
	 * @return Velox\Content\Content
	 */
	public function update( Content $content )
	{
		$this->model = $content;

		if ( ! $this->validate() )
		{
			return null;
		}

		$this->fill();
		$this->save();

		return $this->model;
	}

}
