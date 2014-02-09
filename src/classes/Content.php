<?php namespace Tlr\Types;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Tlr\Types\Facades\TypeSet;

class Content extends Eloquent {

	protected $fillable = [ 'title', 'slug', 'language_id', 'author_id', 'published_at' ];

	/**
	 * The Content Type
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function content()
	{
		return $this->morphTo();
	}

	public function scopeOfType( $query, Definition $type )
	{
		return $query->where('content_type', $type);
	}

	/**
	 * Return the fully qualified relation class
	 * @param  string $slug
	 * @return string
	 */
	public function getContentTypeAttribute( $slug )
	{
		return TypeSet::type( $slug )->type();
	}

	/**
	 * Mutate a type defintion into a type slug for saving in database
	 * @param  string $slug
	 * @return string
	 */
	public function setContentTypeAttribute( $slug )
	{
		if ( $slug instanceof Definition )
		{
			return $this->attributes[ 'content_type' ] = (string)$slug;
		}

		if ( is_string($slug) )
		{
			return $this->attributes[ 'content_type' ] = (string)TypeSet::type( $slug );
		}
	}

}
