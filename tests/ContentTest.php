<?php

use Mockery as m;

use Tlr\Types\Facades\TypeSet;

class ContentTest extends \PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}

	public function setUp()
	{
		$this->type = m::mock('Tlr\Types\Definition');
		$this->content = new Tlr\Types\Content;
	}

	public function testContentTypeSetter()
	{
		TypeSet::shouldReceive('findByKey')
			->once()
			->with('foo', 'modelClass')
			->andReturn('bar');

		$this->content->content_type = 'foo';

		$this->assertEquals( 'bar', $this->content->getAttributes()['content_type'] );
	}

	public function testGetTypeAttribute()
	{
		TypeSet::shouldReceive('findByKey')
			->once()
			->with('foo', 'modelClass')
			->andReturn('bar');

		$this->content->content_type = 'foo';

		TypeSet::shouldReceive('type')
			->once()
			->with('bar')
			->andReturn('baz');

		$this->assertEquals( 'baz', $this->content->type );

	}

	public function testGetContentTypeAttribute()
	{
		TypeSet::shouldReceive('findByKey')
			->once()
			->with('foo', 'modelClass')
			->andReturn('bar');

		$this->content->content_type = 'foo';

		$definition = m::mock();

		$definition->modelClass = 'baz';

		TypeSet::shouldReceive('type')
			->once()
			->with('bar')
			->andReturn($definition);

		$this->assertEquals( 'baz', $this->content->content_type );

	}
}
