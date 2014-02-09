<?php

use Mockery as m;

class TypeSetTest extends \PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->typeset = new Tlr\Types\TypeSet;
	}

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testAddByModel()
	{
		$definition = $this->definition();

		$this->typeset['woop'] = $definition;

		$this->assertSame( $definition, $this->typeset->type('woop') );
	}

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testAddByArray()
	{
		$definition = array(
			'name' => 'foo',
			'classes' => array(
				'model' => 'fooModel',
				'repository' => 'fooRepository',
			),
			'views' => array(
				'fields' => 'fooFields',
			),
			'config' => array(),
		);

		$this->typeset->add('key', $definition);

		$this->assertTrue( $this->typeset['key'] instanceof Tlr\Types\Definition );
		$this->assertSame( 'foo', $this->typeset['key']->name() );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAssignmentError()
	{
		$this->typeset->add('woop', 'woop');
	}

	public function testConstructorAssignment()
	{
		$types = array(
			'foo' => $this->definition(),
			'bar' => $this->definition(),
			'baz' => $this->definition(),
		);
		$this->typeset = new Tlr\Types\TypeSet( $types );

		foreach ($types as $type => $definition) {
			$this->assertTrue( isset( $this->typeset[$type] ) );
		}
	}

	public function testIsSet()
	{
		$this->typeset['woop'] = $this->definition();

		$this->assertFalse( isset($this->typeset['foo']) );

		$this->assertTrue( isset($this->typeset['woop']) );
	}

	public function testUnset()
	{
		$this->typeset['woop'] = $this->definition();

		unset($this->typeset['woop']);

		$this->assertFalse( isset($this->typeset['woop']) );
	}

	protected function definition()
	{
		return m::mock('Tlr\Types\Definition');
	}

}
