<?php namespace Velox\Content\Type\Contracts;

interface ContentTypeRepositoryInterface {

	/**
	 * Validate the given data
	 * @param  array $input
	 * @return boolean
	 */
	public function validate();

	/**
	 * Get an array of errors
	 * @return array
	 */
	public function getErrors();

	/**
	 * Store
	 * @param  array $input
	 * @return Velox\Content\Type\Contracts\ContentTypeModelInterface
	 */
	public function create( $model, $input, $files );

	/**
	 * Store
	 * @param  array $input
	 * @return Velox\Content\Type\Contracts\ContentTypeModelInterface
	 */
	public function update( $model, $input, $files );

	/**
	 * Soft-Delete the data
	 * @param  array $input
	 * @return Velox\Content\Type\Contracts\ContentTypeModelInterface
	 */
	public function softDelete( $model );

	/**
	 * Delete the data
	 * @param  array $input
	 * @return Velox\Content\Type\Contracts\ContentTypeModelInterface
	 */
	public function delete( $model );

}
