<?php

require_once( 'modelTest.php' );

class BleetModelTest extends ModelTest
{

	protected $configuration = array();

	public function setUp()
    {  
        $this->mockModel( 
        	'Framfurt\Model\BleetBleetModel' );
        
		$this->configuration['max_characters'] = 200;
    }

	public function testThatInsertBleet()
	{
		$this->assertTrue( 
						
				$this->object->setBleet( 
							'Lorem ipsum dolor sit amet, consectetur adipiscing', 
							1, 
							$this->configuration 
							),
				'Input arguments incorrect'

			);
	}

	public function testThatInsertEmptyBleet()
	{

		$this->assertFalse( 
							$this->object->setBleet( 
							'', 
							1, 
							$this->configuration 
							),
				'Input arguments incorrect'

			);
	}

	public function testThatInsertEmptyBleetWithExeededCharacters()
	{

		$this->assertFalse( 
			$this->object->setBleet( 
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mi tellus, ultricies a laoreet in, rutrum in dolor. Morbi rhoncus pretium leo, ut fringilla nisi consectetur et. Mauris facilisis consectetur libero sed lobortis. Nulla sit amet sapien nisl, non ultrices est. Vivamus a elementum tellus.', 
				1, 
				$this->configuration 
			),
			'Input arguments incorrect'
		);
	}

	public function testThatInsertBleetAndFailExecute()
	{			
		$this->db->expects( $this->any() )
				->method( 'execute' ) 
				->will( $this->throwException( new \RuntimeException ) );
					 
	

		$this->object->setBleet( 
								'Lorem ipsum dolor sit.',				
								1, 
								$this->configuration 
										);

	}

	public function testThatInsertBleetWithAMention()
	{

		$this->db->expects( $this->exactly(3) )
				->method( 'execute' ) ;
				

		$this->object->setBleet( 
								'Lorem ipsum dolor sit @carlos lorem.',
								1, 
								$this->configuration 
							);
	}
}