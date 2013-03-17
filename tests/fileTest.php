<?php

use Framfurt\Core\File;

class Filetest extends PHPUnit_Framework_TestCase
{
	protected $file;
	
	public function setUp()
	{
		$this->file = new File;
	}

	public function testThathCreateDirectoryReturnsTrueIfDirectoryAlreadyExists()
	{
		$this->assertTrue( $this->file->createDirectory( '/tmp/' ) );
	}

	public function testThathCreateDirectoryReturnsTrueOnSuccessCreatingDirectory()
	{
		$this->assertTrue( $this->file->createDirectory( '/tmp/temp_dir/' ) );

		rmdir( '/tmp/temp_dir' );
	}
}