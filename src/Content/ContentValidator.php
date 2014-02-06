<?php namespace Velox\Content;

use Validator;
use Velox\Support\Validator as VeloxValidator;

class ContentValidator extends VeloxValidator {

	protected $rules = [
		'title' => 'required',
		'slug' => 'required', // @todo validate url friendly
		'published_at' => 'date',
		'author_id' => 'required|exists:users,id',
		'language_id' => 'exists:langauges,iso'
	];

}
