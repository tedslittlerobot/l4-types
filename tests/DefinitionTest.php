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
			'foo' => 'fooClass',
			'bar' => 'barClass',
		);

		$this->views = array(
			'foo' => 'fooView',
			'bar' => 'barView',
		);

		$this->config = array(
			'foo' => 'fooConfig',
			'bar' => 'barConfig',
		);

		$this->definition = new Tlr\Types\Definition( $this->name, $this->slug, $this->classes, $this->views, $this->config );
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

	public function testDynamicClassAccess()
	{
		foreach ($this->classes as $key => $name)
		{
			$property = lcfirst(studly_case($key)) . 'Class';
			$this->assertEquals( $name, $this->definition->{$property} );
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
	 * Test view array access
	 */
	public function testDynamicViewAccess()
	{
		foreach ($this->views as $key => $name)
		{
			$property = lcfirst(studly_case($key)) . 'View';

			$this->assertEquals( $name, $this->definition->{$property} );
		}
	}

	/**
	 * Test config array access
	 */
	public function testConfigAccess()
	{
		foreach ($this->config as $key => $config)
		{
			$this->assertSame( $config, $this->definition->config( $key ) );
		}
	}

	/**
	 * Test config array access
	 */
	public function testDynamicConfigAccess()
	{
		foreach ($this->config as $key => $config)
		{
			$property = lcfirst(studly_case($key));

			$this->assertEquals( $config, $this->definition->{$property} );
		}
	}

	public function testStringable()
	{
		$this->assertEquals( $this->slug, (string)$this->definition );
	}

	public function testSlugAccessor()
	{
		$this->assertEquals( $this->slug, $this->definition->slug() );
	}


}
