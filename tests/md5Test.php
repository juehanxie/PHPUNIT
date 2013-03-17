<?php

use Framfurt\Core\Md5;

class Md5Test extends PHPUnit_Framework_TestCase
{
	public function testIfencryptionISmd5()
	{
		$md5 = new Md5;

		$this->assertEquals( 'fcea920f7412b5da7be0cf42b8c93759', $md5->encrypt( '1234567' ) );
	}
}