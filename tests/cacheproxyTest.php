<?php
/*
use Framfurt\Core\CacheProxy;
use Framfurt\Core\Memcached;
use Framfurt\Model\StaffStaffModel;
use Framfurt\Model\Db;

class CacheProxyTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
		$this->proxy = new CacheProxy;
		$this->cache = $this->getMock( 'Memcached' );
		$this->model = $this->getMock( 'StaffStaff' );
	}

	public function testThatGetReturnsDataFromCache()
	{
		$this->cache->expects( $this->once() )
					->method( 'MethodToGet' )
					->will( $this->returnValue( 'data_retrieved' ) );

		$this->model->expects( $this->never() )
					->method( 'get' );	
	}

	public function testthatgetReturnsDataFromTheSource()
	{
		$this->model->expects( $this->once() )
					->method( 'MethodToGet' )
					->will( $this->returnValue( 'data_retrieved' ) );

		$this->cache->expects( $this->never() )
					->method( 'get' );


		$this->assertEquals( 'data_retrieved', $this->proxy->get( 'StaffStaff', 'MethodToGet' ) );


	}
}*/