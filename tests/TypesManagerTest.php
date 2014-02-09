<?php

use Mockery as m;

class TypesManagerTest extends \PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->manager = new Tlr\Types\TypesManager( 'default', array('default' => array()) );
	}

	public function testGetSelf()
	{
		$this->assertSame($this->manager, $this->manager->getManager());
	}

	public function testGetTypeSet()
	{
		$set = $this->manager->typeSet('default');

		$this->assertInstanceOf('Tlr\Types\TypeSet', $set);
	}

	public function testAddTypeSet()
	{
		$set = $this->manager->addTypeSet( 'foo', array() );

		$this->assertSame( $set, $this->manager->typeSet('foo') );
	}

	public function testGetDefaultTypeSet()
	{
		$set = $this->manager->addTypeSet('default', array());

		$this->assertSame( $set, $this->manager->getDefaultTypeSet() );
		$this->assertSame( $this->manager->getDefaultTypeSet(), $this->manager->typeSet()  );
	}

	public function testConstructWithoutDefault()
	{
		$this->manager = new Tlr\Types\TypesManager( 'default', array('foo' => array()) );

		$this->manager->typeSet();
	}

	public function testSetDefaultTypeSet()
	{
		$default = $this->manager->addTypeSet('woop', array());

		$this->assertSame($this->manager->typeSet(), $this->manager->typeSet('default'));

		$this->manager->setDefaultTypeSet('woop');

		$this->assertSame($this->manager->typeSet(), $this->manager->typeSet('woop'));
	}

}
