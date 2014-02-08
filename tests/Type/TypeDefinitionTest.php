<?php

use Mockery as m;

class TypeDefinitionTest extends \PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->name = 'baz';
		$this->slug = 'key';

		$this->classes = array(
			'model' => 'fooModel',
			'repository' => 'fooRepository',
		);

		$this->views = array(
			'fields' => 'fooFields',
			'bar' => 'barView',
		);

		$this->config = array(
			'foo' => 'fooConfig',
			'bar' => 'barConfig',
		);

		$this->app = m::mock('Illuminate\Application');

		$this->definition = new Tlr\Types\Definition( $this->app, $this->name, $this->slug, $this->classes, $this->views, $this->config );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testRequiredClass()
	{
		new Tlr\Types\Definition( $this->app, $this->name, $this->slug, array(), $this->views, $this->config );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testRequiredView()
	{
		new Tlr\Types\Definition( $this->app, $this->name, $this->slug, $this->classes, array(), $this->config );
	}

	/**
	 * Test class array access
	 */
	public function testClassAccess()
	{
		foreach ($this->classes as $key => $name)
		{
			$this->assertSame( $name, $this->definition->classname( $key ) );
		}
	}

	/**
	 * Test config array access
	 */
	public function testConfigAccess()
	{
		foreach ($this->config as $key => $name)
		{
			$this->assertSame( $name, $this->definition->config( $key ) );
		}
	}

	/**
	 * Test view array access
	 */
	public function testViewAccess()
	{
		foreach ($this->views as $key => $name)
		{
			$this->assertSame( $name, $this->definition->view( $key ) );
		}
	}

	/**
	 * Test the required accessors
	 */
	public function testReqiredViewAccessors()
	{
		$this->assertSame( $this->views['fields'], $this->definition->fields() );
	}

	/**
	 * Test the required accessors
	 */
	public function testModelAccessor()
	{
		$this->app->shouldReceive('make')
			->with( $this->classes['model'] )
			->once()
			->andReturn('woopModel');
		$this->assertSame( 'woopModel', $this->definition->model() );
	}

	/**
	 * Test the required accessors
	 */
	public function testRepoAccessor()
	{
		$this->app->shouldReceive('make')
			->with( $this->classes['repository'] )
			->once()
			->andReturn('woopRepo');
		$this->assertSame( 'woopRepo', $this->definition->repository() );
	}

	public function testStringable()
	{
		$this->assertEquals( json_encode($this->definition), (string)$this->definition );
	}

}
