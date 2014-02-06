<?php namespace Velox\Content\Type;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent {

	// protected $softDelete = true;

	/**
	 * The content object
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function parent()
	{
		return $this->morphOne('Velox\Content\Content', 'content', 'content_type');
	}

}
