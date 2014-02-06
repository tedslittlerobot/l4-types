<?php namespace Velox\Content\Type\Contracts;

interface ContentTypeModelInterface {

	/**
	 * The parent content object
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return Illuminate\Database\Eloquent\Relations\MorphOne
	 */
	public function content();

}
