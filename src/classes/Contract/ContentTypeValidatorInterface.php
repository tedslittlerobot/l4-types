<?php namespace Tlr\Types\Contract;

interface ContentTypeValidatorInterface {

	/**
	 * Validate the given input
	 * @param  array $input
	 * @return Illuminate\Validation\Validator
	 */
	public function validate( $input );

}
