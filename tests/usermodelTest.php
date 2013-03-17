<?php

use Framfurt\Model\UserUserModel;

class UserUserModelTest extends PHPUnit_Framework_TestCase
{
	protected $object;

	protected $db;
	protected $cache;
	protected $searcher;

	public function setUp()
	{
		$this->db 		= $this->getMock( 'Framfurt\Core\Db', array( 'prepare', 'execute', 'fetchAll', 'query', 'bindParam' ), array(), '', false );
		$this->cache 	= $this->getMock( 'Framfurt\Core\Memcached', array( ), array(), '', false );
		$this->object 	= new UserUserModel( $this->db, $this->cache );
		$this->encrypter = $this->getMock( 'Framfurt\Core\Encrypter', array( ), array(), '', false );
	}

	public function testThatinsetUserWorks()
	{
		$this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 'a', '' );
	}

	public function testThatParamsAreNotValid()
	{
		$result = $this->object->insertUser( $this->encrypter, '', '', '', '', '', '' );
		$this->assertEquals( 'Please fill all the fields', $result );
	}

	public function testThatPassWordIsWrong()
	{

		$result = $this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 're', '' );
		$this->assertEquals( 'Both passwords must be equals', $result );
	}

	public function testThatReturnTrue()
	{
		$result = $this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 'a', '' );
		$this->assertTrue( $result );
	}


	public function testThatReturnFalse()
	{
		$this->db->expects( $this->any() )
			->method( 'execute' )	
			->will($this->throwException(new \RuntimeException) );
		$result = $this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 'a', '' );
		$this->assertEmpty( $result );
	}

	public function testThatReturnTrueInsertingHash()
	{
		$this->db->expects( $this->any() )
		->method( 'execute' )	
		->will($this->returnValue( true ) );
		$this->db->expects( $this->once() )
		->method( 'fetchAll' )	
		->will($this->returnValue( array( 0 => array( 'user_id' => 22 ) ) ) );
		$result = $this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 'a', '' );
		$this->assertTrue( $result );
	}

	public function testThatOcoursAnErrorGettingTheUserIDWhenGeneratingHash()
	{
		$this->db->expects( $this->any() )
		->method( 'execute' )	
		->will($this->returnValue( true ) );
		$this->db->expects( $this->any() )
		->method( 'fetchAll' )	
		->will($this->throwException(new \RuntimeException) );
		$result = $this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 'a', '' );
		$this->assertTrue( $result );
	}

	public function testThatOcoursAnErrorGettingTheUserIDWhenGeneratingHashErrorInsertingHash()
	{

		$this->db->expects( $this->at( 14 ) )
		->method( 'execute' )	
		->will($this->throwException(new \RuntimeException) );

		$this->db->expects( $this->once( ) )
		->method( 'fetchAll' )	
		->will($this->returnValue( array( 0 => array( 'user_id' => 22 ) ) ) );

		$result = $this->object->insertUser( $this->encrypter, 'a', 'a', 'a', 'a', 'a', '' );
		$this->assertTrue( $result );
	}


}