<?php

use Mockery as m;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class RepositoryTest extends \PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->type = m::mock('Tlr\Types\Definition');
		$this->typeRepo = m::mock();

		Input::shouldReceive('all')->andReturn( $this->inputData() );

		$this->model = m::mock( 'Tlr\Types\Content' );

		$this->repo = new Tlr\Types\Repository( $this->model );

		$this->repo->type($this->type);
	}

	protected function inputData()
	{
		return array();
	}

	protected function expectToGetRepo($count = 1)
	{
		$this->type->shouldReceive('repository')
			->times($count)
			->andReturn( $this->typeRepo );
	}

	protected function expectToValidate( $passes = true, $typePasses = true )
	{
		$this->val = m::mock('Illuminate\Validation\Validator');

		$this->data = array();
		$this->files = array();

		Validator::shouldReceive('make')
			->once()
			->with($this->inputData(), $this->repo->getRules())
			->andReturn( $this->val );

		$this->val->shouldReceive('getData')->once()->andReturn($this->data);
		$this->val->shouldReceive('getFiles')->once()->andReturn($this->files);
		$this->val->shouldReceive('passes')->once()->andReturn($passes);

		$this->typeRepo->shouldReceive('validate')->andReturn($typePasses);
	}

	/**
	 * Test the type assignment has worked
	 */
	public function testTypeAssignment()
	{
		$this->assertSame( $this->type, $this->repo->type() );
	}

	/**
	 * Test the cached type repository
	 */
	public function testGetCachedRepository()
	{
		$this->expectToGetRepo();
		$this->assertSame( $this->typeRepo, $this->repo->getRepository() );
		$this->assertSame( $this->repo->getRepository(), $this->repo->getRepository() );
	}

	public function testValidation()
	{
		$this->expectToGetRepo();
		$this->expectToValidate();

		$this->assertSame( true, $this->repo->validate() );
	}

	public function testFailedTypeValidation()
	{
		$this->expectToGetRepo();
		$this->expectToValidate(true, false);

		$this->assertSame( false, $this->repo->validate() );
	}

	public function testErrorRetrieval()
	{
		$this->expectToGetRepo();
		$this->expectToValidate(false, false);

		$typeMessageBag = m::mock();
		$this->typeRepo->shouldReceive('getErrors')->andReturn($typeMessageBag);
		$typeMessageBag->shouldReceive('toArray')->andReturn( array() );

		$messageBag = m::mock();
		$messageBag->shouldReceive('merge')->with( array() )->andReturn($messageBag);

		$this->val->shouldReceive('getMessageBag')->andReturn($messageBag);

		$this->assertSame( false, $this->repo->validate() );
		$this->assertSame( $messageBag, $this->repo->getErrors() );
	}

}
