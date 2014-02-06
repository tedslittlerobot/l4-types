<?php namespace Velox\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Tag extends Eloquent {

	protected $fillable = [ 'name', 'slug' ];

	/**
	 * The contents with this tag
	 * @return Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function contents()
	{
		return $this->morphedByMany('Velox\Content\Content', 'taggable');
	}

}
