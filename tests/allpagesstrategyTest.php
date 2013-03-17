<?php

use Framfurt\Core\Pagination\AllPagesStrategy;

class AllPagesStrategyTest extends PHPUnit_Framework_TestCase
{
	protected $object;

	public function setUp()
	{
		$this->object = new AllPagesStrategy;
	}

	public function testThatGetStartPageReturnsTheFirstPage()
	{
		$this->assertEquals( 1, $this->object->getStartPage(), 'The first page should be 1 always' );
	}

	public function testThathGetEndPageReturnsTheLastPage()
	{
		$last_page = 10;
		$this->object->setLastPage( $last_page );

		$this->assertEquals( $last_page, $this->object->getEndPage() );
	}

	public function testThatGetEndPageThrowsErrorIfSetLastPageWasNotSetted()
	{
		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();
	}

	public function testThatSetCurrentPageDoesntAlterFunctionality()
	{
		$last_page = 10;
		$this->object->setCurrentPage( -1 );
		$this->object->setLastPage( $last_page );

		$this->assertEquals( $last_page, $this->object->getEndPage() );
	}

	public function testThatSetMaxPagesPerRowDoesntAlterFunctionality()
	{
		$last_page = 10;
		$this->object->setMaxPagesPerRow( 0 );
		$this->object->setLastPage( $last_page );

		$this->assertEquals( $last_page, $this->object->getEndPage() );
	}
}