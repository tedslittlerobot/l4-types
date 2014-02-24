<?php namespace Tlr\Types;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Tlr\Types\Facades\TypeSet as TypeSetFacade;

class Content extends Eloquent {

	protected $fillable = [ 'title', 'slug', 'published_at' ];

	/**
	 * The Content Type
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function content()
	{
		return $this->morphTo();
	}

	/**
	 * Narrow the query down by type, passing an optional parameter to filter by that subquery
	 * @param  QueryBuilder     $query
	 * @param  Definition $type
	 * @param  Closure     $subQuery
	 * @return QueryBuilder
	 */
	public function scopeOfType( $query, Definition $type, \Closure $subQuery = null )
	{
		$query->where('content_type', $type);

		if ( ! is_null($query) )
		{
			$query->whereHas('content', function( $q ) use ($subQuery)
			{
				$subQuery($q);
			});
		}

		return $query;
	}

	/**
	 * Get the type definition
	 * @return Definition
	 */
	public function getTypeAttribute()
	{
		return TypeSetFacade::type( $this->attributes['content_type'] );
	}

	/**
	 * Return the class of the related model
	 * @param  string $slug
	 * @return string
	 */
	public function getContentTypeAttribute( $slug )
	{
		return $this->type->modelClass;
	}

	/**
	 * Mutate a type defintion into a type slug for saving in database
	 * @param  string $slug
	 * @return string
	 */
	public function setContentTypeAttribute( $classname )
	{
		if ( $classname instanceof Definition )
		{
			return $this->attributes[ 'content_type' ] = (string) $classname;
		}

		if ( is_string($classname) )
		{
			return $this->attributes[ 'content_type' ] = (string) TypeSetFacade::findByKey( $classname, 'modelClass' );
		}
	}

}
