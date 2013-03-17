<?php

require_once( 'controller.php' );

class BleetformTest extends AbstractController
{

	public function setUp()
    {  
        $this->mockController( 'Framfurt\Controller\Shared\SharedBleetformController' );
    }

    public function testThatReciveBleetInTextArea()
    {     	
     	
 		$this->post->expects( $this->at( 0 ) )
 				   ->method( 'getText' )
 				   ->with( 'submit')
 				   ->will( $this->returnValue( 'submit' ) );

 		$this->post->expects( $this->at( 1 ) )
 				   ->method( 'getText' )
 				   ->with( 'bleet_text' )
 				   ->will($this->returnValue( '' ) ); 	

 		$model_mock = $this->getMock( 	'Framfurt\Model\Bleet\BleetBleetModel', 
 										array('setBleet') );

		$model_factory_mock = $this->getMock( 'Framfurt\Core\ModelFactory' );

		$factory_map = array(
			array( 'ModelFactory', $model_factory_mock ),

		);

		$model_map = array(
			array( 'BleetBleet', $this->event, null, $model_mock )
		);		

		$this->core->expects( $this->any() )
				   ->method( 'getClass' )
				   ->will( $this->returnValueMap( $factory_map ) );

		$model_factory_mock->expects( $this->any() )
					  ->method( 'getClass' )
					  ->will( $this->returnValueMap( $model_map ) );

		$model_mock->expects( $this->once() )
					->method( 'setBleet' )	
					->will( $this->returnValue( true ) );

		$this->object->init();
     }

    


}
