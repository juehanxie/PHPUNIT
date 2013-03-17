<?php

use Framfurt\Core\Pagination\JumpingStrategy;

class JumpingStrategyTest extends PHPUnit_Framework_TestCase
{
	protected $object;

	public function setUp()
	{
		$this->object = new JumpingStrategy;
	}

	public function testThatGetStartPageThrowsAnErrorWhenNotCurrentPageWasSetted()
	{
		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getStartPage();
	}

	public function testThatGetStartPageThrowsAnErrorWhenSetMaxPagesPerRowWasNotSetted()
	{
		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->setCurrentPage( 1 );
		$this->object->getStartPage();
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function testThatGetStartPageReturnsTheCorrectPage( $start_page, $current_page )
	{
		$this->object->setMaxPagesPerRow( 5 );

		$this->object->setCurrentPage( $current_page );

		$this->assertEquals( $start_page, $this->object->getStartPage() );
	}

	//Data provider for testThatGetStartPageReturns1InTheSecondPage
	public function dataProvider()
	{
		return array(
			array( 1, 1 ),
			array( 1, 2 ),
			array( 1, 3 ),
			array( 1, 4 ),
			array( 1, 5 ),
			array( 6, 6 ),
			array( 6, 10 ),
			array( 11, 11 ),
			array( 16, 17 )
		);
	}

	public function testThatGetEndPageThrowsErrorIfCurrentPageIsNotSetted()
	{
		$this->object->setMaxPagesPerRow( 5 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();
	}

	public function testThatGetEnPageThrowsErrorIfMaxPagesPerRowIsNotSetted()
	{
		$this->object->setCurrentPage( 1 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();
	}

	/**
	 * @dataProvider endPageProvider
	 */
	public function testThatGetEndPageReturnsTheCorrectPage( $end_page, $current_page )
	{
		$this->object->setMaxPagesPerRow( 5 );
		$this->object->setCurrentPage( $current_page );
		$this->object->setLastPage( 30 );

		$this->assertEquals( $end_page, $this->object->getEndPage() );

	}

	public function endPageProvider()
	{
		return array(
			array( 5, 1 ),
			array( 5, 2 ),
			array( 5, 3 ),
			array( 5, 4 ),
			array( 5, 5 ),
			array( 10, 6 ),
			array( 10, 10 ),
			array( 15, 11 ),
			array( 15, 11 ),
			array( 20, 17 ),

		);
	}

	public function testThatGetEnPageAdjustItselfToTheLastPageIfTheRangeIsGreatter()
	{
		$last_page = 6;

		$this->object->setMaxPagesPerRow( 5 );
		$this->object->setCurrentPage( 6 );
		$this->object->setLastPage( $last_page );

		$this->assertEquals( $last_page, $this->object->getEndPage() );
	}

	public function testThatGetEndPageThrowsAnErroriflastPageIsNotSetted()
	{
		$this->object->setMaxPagesPerRow( 5 );
		$this->object->setCurrentPage( 1 );

		$this->setExpectedException( 'InvalidArgumentException' );

		$this->object->getEndPage();

	}
}

