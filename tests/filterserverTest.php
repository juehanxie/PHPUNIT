<?php

class FilterServerTest extends PHPUnit_Framework_TestCase
{
	protected $filter;
	public function setUp()
	{
		$_SERVER['html_text']		= '<p><strong>Testing</strong></p>';
		$_SERVER['html_quotes']	= "<p><strong>'Testing'</strong></p>";
		$_SERVER['number']			= 13;
		$_SERVER['string_number']	= '13';
		$_SERVER['valid_email']	= 'myemail@mydomain.ltd';
		$_SERVER['invalid_email']	= 'myemail@mydomain.lt;d';

		$this->filter = new Framfurt\Core\FilterServer();
	}

	public function testThatGetGlobalDoesNotExists()
	{
		$this->assertFalse( isset( $_SERVER ) );
	}

	public function testThatGetFilterHaveData()
	{
		$this->assertTrue( $this->filter->haveData() );
	}

	public function testThatGetFilterDoesntHaveData()
	{
		$_SERVER = array();
		$filterget = new Framfurt\Core\FilterServer();

		$this->assertFalse( $filterget->haveData() );
	}

	public function testGetTextOfAnHtmlKey()
	{
		$this->assertEquals( 'Testing', $this->filter->getText( 'html_text' ), 'GetText must remove html tags' );
	}

	public function testGetOfAnNonExistingKey()
	{
		$this->setExpectedException( 'UnexpectedValueException' );
		$this->filter->getText( 'nonExistingKey' );
	}

	public function testGetOfANonExistingKeyWithDefaultValue()
	{
		$this->assertEquals( 'Default value', $this->filter->getText( 'nonExistingKey', 'Default value' ), 'The default value is not used' );
	}

	public function testGetOfHTmlStringWithSomeHtmlAvailable()
	{
		$this->assertEquals( '<p>Testing</p>', $this->filter->getHtml( 'html_text', '<p>' ), 'Key must have only P html tags' );
	}

	public function testGetOfHTmlStringWithSingleQuotes()
	{
		$this->assertEquals( "<p>\'Testing\'</p>", $this->filter->getHtml( 'html_quotes', '<p>' ), 'Content must have scaped quotes' );
	}

	public function testGetOfNonExistingHtmlKeyThrowsAnError()
	{
		$this->setExpectedException( 'UnexpectedValueException');
		$this->filter->getHtml( 'nonExistingKey' );
	}

	public function testGetOfNonExistingHtmlKeyReturnsDefault()
	{
		$this->assertEquals( 'Default value', $this->filter->getHtml( 'nonExistingKey', '', 'Default value' ), 'The default value is not used' );
	}

	public function testGetOfANumber()
	{
		$this->assertEquals( 13, $this->filter->getNumber( 'number' ), 'Number must return the same number' );
	}

	public function testGetOfAStringifyNumberConvertsToFloat()
	{
		$this->assertInternalType( 'float', $this->filter->getNumber( 'string_number' ) );
	}

	public function testGetOfInvalidNumberFilterThrowsAnException()
	{
		$this->setExpectedException( 'UnexpectedValueException' );
		$this->filter->getNumber( 'html_text' );
	}

	public function testGetOfInvalidNumberFilterReturnsDefault()
	{
		$this->assertEquals( 13, $this->filter->getNumber( 'html_text', 13 ), 'Must return default value' );
	}

	public function testGetOfStringWithNumberFilterThrowsException()
	{
		$this->setExpectedException( 'UnexpectedValueException' );
		$this->filter->getNumber( 'nonExistingKey' );
	}

	public function testGetOfStringWithNumberFilterReturnsDefault()
	{
		$this->assertEquals( 1, $this->filter->getNumber( 'nonExistingKey', 1 ), 'Method must return default value of 1' );
	}

	public function testGetOfAValidEmail()
	{
		$this->assertEquals( 'myemail@mydomain.ltd', $this->filter->getEmail( 'valid_email' ), 'Email should be valid' );
	}

	public function testGetOfAnEmailWithInvalidCharactersSanitizesIt()
	{
		$this->assertEquals( 'myemail@mydomain.ltd', $this->filter->getEmail( 'invalid_email' ), 'Email should be sanitized' );
	}

	public function testGetOfANonExistingEmailThrowsAnError()
	{
		$this->setExpectedException( 'UnexpectedValueException' );
		$this->filter->getEmail( 'email_does_not_exists' );
	}

	public function testGetOfANonExistingEmailReturnsDefaultValue()
	{
		$this->assertEquals( 'default value', $this->filter->getEmail( 'email_does_not_exists', 'default value' ), 'getEmail should return a default value' );
	}
}