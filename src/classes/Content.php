<?php namespace Tlr\Types;
<?php namespace Velox\Content;

use Velox;
use Velox\Content\Type\Definition;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Content extends Eloquent {

	protected $fillable = [ 'title', 'slug', 'language_id', 'author_id', 'published_at' ];

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

		return $query->where('content_type', $type->slug());
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
	 * Return the fully qualified relation class
	 * @param  string $slug
	 * @return string
	 */
	public function getContentTypeAttribute( $slug )
	{
		return Velox::type( $slug )->type();
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
			return $this->attributes[ 'content_type' ] = $slug->slug();
		}

		if ( is_string($slug) )
		{
			return $this->attributes[ 'content_type' ] = Velox::type( $slug )->slug();
		}
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
