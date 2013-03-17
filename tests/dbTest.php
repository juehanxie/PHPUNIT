<?php

use Framfurt\Core\Db;
use Framfurt\Core\DbException;
use Framfurt\Core\ConnectorInterface;
use Framfurt\Core\ConnectorPdoWrapper;

// :TODO: Move to 100% coverage, gives problems with the statement object
class DbTest extends PHPUnit_Framework_TestCase
{
	protected $wrapper;
	protected $db;
	
	public function setUp()
	{
		$this->wrapper   = $this->getMock( 'Framfurt\Core\ConnectorPdoWrapper', array(), array(), '', false );

		$this->db = new Db( $this->wrapper );
	}

	public function testThathConnecThrowsExceptionWhenConnectFails()
	{
		$this->wrapper->expects( $this->once() )
					  ->method( 'connect' )
					  ->will( $this->throwException( new Framfurt\Core\DbException ) );

		$this->setExpectedException( 'Framfurt\Core\DbException' );

		$this->db->prepare( 'sql' );
	}

	public function testThatPrepareCallsConnectAndPrepareWrappers()
	{
		$this->wrapper->expects( $this->once() )
					  ->method( 'connect' );
		$this->wrapper->expects( $this->once() )
					  ->method( 'prepare' );

		$this->db->prepare( 'sql' );
	}

	public function testThathBindParamThrowErrorWhenNoStatementInitialized()
	{
		$this->setExpectedException( 'Framfurt\Core\DbStatementException' );

		$this->db->bindParam( ':name', 'value', 1 );
	}

	public function testThathfetchThrowErrorWhenNoStatementInitialized()
	{
		$this->setExpectedException( 'Framfurt\Core\DbStatementException' );

		$this->db->fetch();
	}

	public function testThathfetchAllThrowErrorWhenNoStatementInitialized()
	{
		$this->setExpectedException( 'Framfurt\Core\DbStatementException' );

		$this->db->fetchAll();
	}

	public function testThathexecuteThrowErrorWhenNoStatementInitialized()
	{
		$this->setExpectedException( 'Framfurt\Core\DbStatementException' );

		$this->db->execute();
	}
}
