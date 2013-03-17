<?php

use Framfurt\Core\Pagination\SlidingStrategy;

class SlidingStrategyTest extends PHPUnit_Framework_TestCase
{
	protected $object;

	public function setUp()
	{
		$this->object = new SlidingStrategy;
	}

	/**
	 * @dataProvider getstartPageProvider
	 */
	public function testThatGetStartPageReturnsThefirstPage( $current_page, $start_page )
	{
		$this->object->setCurrentPage( $current_page );
		$this->object->setMaxPagesPerRow( 5 );

		$this->assertEquals( $start_page, $this->object->getStartPage() );
	}

	public function getStartPageProvider()
	{
		return array(
			array( 1, 1 ),
			array( 2, 1 ),
			array( 3, 1 ),
			array( 4, 2 ),
			array( 5, 3 ),
			array( 10, 8 ),
		);
	}

	public function testThatGetStartPageReturnsTheFirstPageWithDifferentRange()
	{
		$this->object->setCurrentPage( 5 );
		$this->object->setMaxPagesPerRow( 7 );

		$this->assertEquals( 2, $this->object->getStartPage() );
	}

	public function testThatGetStartPageThrowsAnErrorWhenMaxPagesIsNotSet()
	{
		$this->object->setCurrentPage( 5 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getStartPage();
	}

	public function testThatGetEndPageThrowsAnErrorWhenCurrentPageIsNotSet()
	{
		$this->object->setMaxPagesPerRow( 5 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getStartPage();
	}


	/**
	 * @dataProvider getLastPageProvider
	 */
	public function testThatGetLastPageReturnstheLastPage( $current_page, $last_page )
	{
		$this->object->setMaxPagesPerRow( 5 );
		$this->object->setCurrentPage( $current_page );
		$this->object->setLastPage( 30 );

		$this->assertEquals( $last_page, $this->object->getEndPage() );
	}

	public function getLastPageProvider()
	{
		return array(
			array( 1, 5 ),
			array( 2, 5 ),
			array( 3, 5 ),
			array( 4, 6 ),
			array( 5, 7 ),
			array( 10, 12)
		);
	}

	public function testThatGetLastPageWorksWithAnotherRange()
	{
		$this->object->setMaxPagesPerRow( 7 );
		$this->object->setCurrentPage( 6 );
		$this->object->setLastPage( 10 );

		$this->assertEquals( 9, $this->object->getEndPage() );
	}

	public function testThatGetLastPageDontRaiseTheLastPage()
	{
		$this->object->setMaxPagesPerRow( 5 );
		$this->object->setCurrentPage( 6 );
		$this->object->setLastPage( 6 );

		$this->assertEquals( 6, $this->object->getEndPage() );
	}

	public function testThatGetLastPageThrowsErrorwhenMaxPagesPerRowIsNotSetted()
	{
		$this->object->setCurrentPage( 6 );
		$this->object->setLastPage( 6 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();
	}

	public function testThatGetLastPageThrowsErrorWhenCurrentPageIsNotSetted()
	{
		$this->object->setMaxPagesPerRow( 6 );
		$this->object->setLastPage( 6 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();
	}

	public function testThatGetLastPageThrowsErrorWhenLastPageIsNotSetted()
	{
		$this->object->setCurrentPage( 6 );
		$this->object->setMaxPagesPerRow( 6 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();
	}
}