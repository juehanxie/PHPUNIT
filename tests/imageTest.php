<?php

use Framfurt\Core\Image;

//:TODO: finish testing creating/deleting the test image maybe?
class ImageTest extends PHPUnit_Framework_TestCase
{
	protected $image;

	public function setUp()
	{
		$this->image = new Image();


		$this->image_path = '/tmp/test_image';
		$image = new Imagick();
		$image->newImage(100, 100, new ImagickPixel('red'));
		$image->setImageFormat('png');
		$image->writeImage( $this->image_path );

	}

	public function tearDown()
	{
		@unlink( $this->image_path );
	}

	public function testThathLoadReturnsFalseWhenFileDoesNotExists()
	{
		$this->assertFalse( $this->image->load( '/invalid/path/to/image' ) );
	}

	public function testThathLoadReturnsTrueWhenFileExists()
	{
		$this->assertTrue( $this->image->load( $this->image_path ) );
	}
	
	public function testThathResizeReturnsFalseWhenFailsResizing()
	{
		$this->assertFalse( $this->image->resize( 20, 20 ) );
	}

	public function testThatResizeReturnsTrueWhenSuccess()
	{
		$this->image->load( $this->image_path );

		$this->assertTrue( $this->image->resize( 20,20 ) );
	}

	public function testThathWriteReturnsFalseWhenCantCreateDirectories()
	{
		$file_handler = $this->getMock( 'Framfurt\\Core\\File' );

		$file_handler->expects( $this->once() )
					 ->method( 'createDirectory' )
					 ->will( $this->returnValue( false ) );


		$this->assertFalse( $this->image->write( $file_handler, '/new/path/', 'new_image_name' ) );
	}

	public function testThathWriteReturnsFalseWhenCantWriteTheImage()
	{
		$file_handler = $this->getMock( 'Framfurt\\Core\\File' );

		$file_handler->expects( $this->once() )
					 ->method( 'createDirectory' )
					 ->will( $this->returnValue( true ) );

		$this->image->load( $this->image_path );

		$this->assertFalse( $this->image->write( $file_handler, '/new/path/', 'new_image_name' ) );	
	}

	public function testThathWriteReturnsTrueOnWriteSuccess()
	{
		$file_handler = $this->getMock( 'Framfurt\\Core\\File' );

		$file_handler->expects( $this->once() )
					 ->method( 'createDirectory' )
					 ->will( $this->returnValue( true ) );

		$this->image->load( $this->image_path );

		$this->assertTrue( $this->image->write( $file_handler, '/tmp/', 'new_image_name' ) );

		unlink( '/tmp/new_image_name' );
	}

	public function testThathgetImageExtensionReturnsTheCorrectExtensionType()
	{
		$this->image->load( $this->image_path );

		$this->assertEquals( 'png', $this->image->getImageExtension() );
	}

	public function testThathgetImageExtensionReturnsJPGforJPEGMimeType()
	{
		$image_path = '/tmp/test_image_2';
		$image = new Imagick();
		$image->newImage(100, 100, new ImagickPixel('red'));
		$image->setImageFormat('jpg');
		$image->writeImage( $image_path );

		$this->image->load( $image_path );

		$this->assertEquals( 'jpg', $this->image->getImageExtension() );

		unlink( '/tmp/test_image_2' );
	}
}