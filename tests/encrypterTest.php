<?php

use Framfurt\Core\Encrypter;

class EncrypterTest extends PHPUnit_Framework_TestCase
{
	protected $method;
	protected $encrypter;
	
	public function setUp()
	{
		$this->method = $this->getMock( 'Framfurt\Core\Md5' );
		$this->encrypter = new Encrypter( $this->method );
	}

	public function testEncryptsCallsEncrypter()
	{
		$this->method->expects( $this->once() )
					 ->method( 'encrypt' );

		$this->encrypter->encrypt( 'text to encrypt ' );
	}

	public function testEncryptsUsesSalt()
	{
		$this->method->expects( $this->once() )
					 ->method( 'encrypt' )
					 ->with( $this->equalto( 'textsalted' ) );

		$this->encrypter->setSalt( 'salted' );
		$this->encrypter->encrypt( 'text' );
	}
}