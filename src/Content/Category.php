<?php namespace Velox\Content;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent {

	protected $fillable = [ 'name', 'slug' ];

	/**
	 * the contents that have this category
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function contents()
	{
		return $this->hasMany( 'Velox\Content\Content' );
	}

}
