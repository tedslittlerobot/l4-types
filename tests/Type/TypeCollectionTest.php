<?php

use Mockery as m;

class TypeCollectionTest extends \PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->app = m::mock('Application');

		$this->collection = new Tlr\Types\Collection( $this->app );
	}

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testAddByModel()
	{
		$definition = $this->definition();

		$this->collection['woop'] = $definition;

		$this->assertSame( $definition, $this->collection['woop'] );
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

		$this->collection->add('key', $definition);

		$this->assertTrue( $this->collection['key'] instanceof Tlr\Types\Definition );
		$this->assertSame( 'foo', $this->collection['key']->name() );
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAssignmentError()
	{
		$this->collection->add('woop', 'woop');
	}

	public function testConstructorAssignment()
	{
		$types = array(
			'foo' => $this->definition(),
			'bar' => $this->definition(),
			'baz' => $this->definition(),
		);
		$this->collection = new Tlr\Types\Collection( $this->app, $types );

		foreach ($types as $type => $definition) {
			$this->assertTrue( isset( $this->collection[$type] ) );
		}
	}

	public function testIsSet()
	{
		$this->collection['woop'] = $this->definition();

		$this->assertFalse( isset($this->collection['foo']) );

		$this->assertTrue( isset($this->collection['woop']) );
	}

	public function testUnset()
	{
		$this->collection['woop'] = $this->definition();

		unset($this->collection['woop']);

		$this->assertFalse( isset($this->collection['woop']) );
	}

	public function testFindByModelWithArrayAccess()
	{
		$this->assertTrue(true);
	}

	public function testFindByModel()
	{
		$this->assertTrue(true);
	}

	protected function definition()
	{
		return m::mock('Tlr\Types\Definition');
	}

}
