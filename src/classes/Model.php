<?php namespace Tlr\Types;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent {

	/**
	 * The content object
	 * @return Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function parent()
	{
		return $this->morphOne('Velox\Content\Content', 'content', 'content_type');
	}

}
