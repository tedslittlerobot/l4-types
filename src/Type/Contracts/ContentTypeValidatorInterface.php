<?php namespace Velox\Content\Type\Contracts;

interface ContentTypeValidatorInterface {

	/**
	 * Validate the given input
	 * @param  array $input
	 * @return Illuminate\Validation\Validator
	 */
	public function validate( $input );

}
