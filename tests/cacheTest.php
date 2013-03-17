<?php

use Framfurt\Core\Cache;

class CacheTest extends PHPUnit_Framework_TestCase
{
	protected $cache;
	protected $event_emmiter;
	protected $configuration;
	
	public function setUp()
	{
		$this->event_emmiter = $this->getMock( 'Framfurt\Core\Events\EventEmitter' );
		$this->configuration = $this->getMock( 'Framfurt\Core\Configuration' );

		$this->cache = Cache::GetInstance( 'Memcached', $this->event_emmiter, $this->configuration );


		$config = array( 'servers' => array() );

		$config['servers'][] = array(
			'host' 		=> 'localhost',
			'port' 		=> 11211
		);

		$this->configuration->expects( $this->any() )
							->method( 'load' )
							->will( $this->returnValue( $config ) );
	}

	public function testThatSetReturnsTrueOnSettingValue()
	{
		$this->assertTrue( $this->cache->set( 'test_key', 'some_value', 1 ) );
		$this->cache->delete( 'test_key' );
	}

	public function testThatGetReturnsFalseWhenNoData()
	{
		$this->assertFalse( $this->cache->get( 'not_existing_key' ) );
	}

	public function testThatGetReturnsValueWhenSuccess()
	{
		$this->cache->set( 'key', 'value', 1 );

		$this->assertEquals( 'value', $this->cache->get( 'key' ) );

		$this->cache->delete( 'key' );
	}

	public function testThatExistsReturnTrueIftheKeyExists()
	{
		$this->cache->set( 'this_key_exists', true, 1 );

		$this->assertTrue( $this->cache->exists( 'this_key_exists' ) );

		$this->cache->delete( 'this_key_exists' );
	}

	public function testThathExistsReturnFalseIfTheKeyDoesNotExists()
	{
		$this->assertfalse( $this->cache->exists( 'this_key_not_exists' ) );
	}

	public function testThatExistsReturnTrueIfTheKeyContainsFalseValue()
	{
		$this->cache->set( 'key_with_false', false, 1 );

		$this->assertTrue( $this->cache->exists( 'key_with_false' ) );

		$this->cache->delete( 'key_with_false' );
	}

	public function testThathDeleteReturnFalseIfTheKeyDoesNotExists()
	{
		$this->assertfalse( $this->cache->delete( 'this_key_not_exists' ) );
	}

	public function testThatDeleteReturnTrueIftheKeyExists()
	{
		$this->cache->set( 'this_key_exists', true, 1 );

		$this->assertTrue( $this->cache->delete( 'this_key_exists' ) );
	}

}