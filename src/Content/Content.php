<?php namespace Velox\Content;

use Velox;
use Velox\Content\Type\Definition;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Content extends Eloquent {

	protected $fillable = [ 'title', 'slug', 'language_id', 'author_id' ];

	protected $softDelete = true;

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
		return $query->where('content_type', $type->classname('model'));
	}

	/**
	 * The Language
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language()
	{
		return $this->belongsTo( 'Velox\I18n\Language' );
	}

	/**
	 * The Author
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo( 'Velox\Auth\User', 'author_id' );
	}

	/**
	 * The Category
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category()
	{
		return $this->belongsTo( 'Velox\Content\Category' );
	}

	/**
	 * The Tags
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags()
	{
		return $this->morphToMany( 'Velox\Content\Tag', 'taggable' );
	}

	/**
	 * Convert content_type to type definition
	 * @return Velox\Content\Type\Definition
	 */
	public function getTypeAttribute()
	{
		return Velox::type( $this->attributes['content_type'] );
	}
}
