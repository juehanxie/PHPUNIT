<?php
use Framfurt\Core\ConnectorPdoStatement;

class ConnectorPdoStatementTest extends PHPUnit_Framework_TestCase
{
	protected $statement;
	protected $connector;
	
	public function setUp()
	{
		$this->statement = $this->getMock( 'PdoStatement' );
		$this->connector = new ConnectorPdoStatement( $this->statement );
	}

	public function testThatBindParamGetsCalled()
	{
		$this->statement->expects( $this->once() )
						->method( 'bindParam' )
						->with( ':name', 'value', 1 );


		$this->connector->bindParam( ':name', 'value', 1 );
	}

	public function testThatExecuteGetsCalled()
	{
		$this->statement->expects( $this->once() )
						->method( 'execute' );

		$this->connector->execute();
	}

	public function testThatExecuteThrowsAnError()
	{
		$this->statement->expects( $this->once() )
						->method( 'execute' );

		$this->statement->expects( $this->once() )
						->method( 'errorInfo' )
						->will( $this->returnValue( array( null, 1, "error info" ) ) );

		$this->setExpectedException( 'RuntimeException' );

		$this->connector->execute();
	}

	public function testThatFetchGetsCalled()
	{
		$this->statement->expects( $this->once() )
						->method( 'fetch' );

		$this->connector->fetch();
	}

	public function testThatFetchAllGetsCalled()
	{
		$this->statement->expects( $this->once() )
						->method( 'fetchAll' );

		$this->connector->fetchAll();
	}	
}