<?php
/**************************************
 * MOCKS ASSERTS *********************
 **************************************/
 
 // Crear MOCK y deshabilitar el constructor
 //-------------------------------------------
 $this->db = $this->getMockBuilder( 'Framfurt\Core\Db' )
                   ->disableOriginalConstructor()
                   ->getMock();
 
 
//  MOCK con returnValueMap:
//--------------------------------------
Para evaluar que en un mock se llama a un mismo metodo 
pero con diferentes arguments y diferentes resultados. 
Problema: no hay restricción de que después de llamar 
a un metodo luego se le llame de nuevo.


public function testThatReciveBleetInTextArea()
{
	//$bleet_text = $this->post->getText('bleet_text');

	$map = array(
			array( 'submit', 'no_submit', 'submit' ),
			array( 'bleet_text', null, '' )
		);
	
	$this->post->expects( $this->any() )
			   ->method( 'getText' )
			   ->will( $this->returnValueMap( $map ));


	$this->object->init();
}


  $this->globals['post']
                        ->expects( $this->at( 0 ) )
                        ->method( 'get' )
                        ->with( 'username' )
                        ->will( $this->returnValue( 'batman' ) );

//  EXEPECTS de MOCK
//---------------------------------------

->expects( $this->once() ) // se le llama una vez
->expects( $this->any() ) // se le llama las veces que quiera
->expects( $this->at(0) ), $this->at(1), $this->at(2) // orden consecutivo de ejecución del objeto mockeado ( sin tener en cuenta los métodos llamados )
->expects( $this->exactly(2) ) // se le llama exactamente n veces


//  WILL de MOCK
//---------------------------------------
->will( $this->onConsecutiveCalls('submit', '')); 
//Llamamos a una funcion y esperamos recibir la primera vez 'submit' y en la segunda recibir ''

->will( $this->returnValue('submit'));


/**************************************
 * NORMAL ASSERTS *********************
 **************************************/

// EXPECTED EXCEPTION
//---------------------------------------
 public function testThatGetEndPageThrowsErrorIfSetLastPageWasNotSetted()
 {
    $this->setExpectedException( 'InvalidArgumentException' );
    $this->object->getEndPage();
 }
 
public function testThatGetFriendsReturnFalseOnDbError()
{
    $this->db->expects( $this->once() )
            ->method( 'execute' )
			->will( $this->throwException( new RuntimeException ) );
 
    $this->assertFalse( $this->object->getFriendsById( $this->user_id ) );
 }
		
  public function testThatGetFriendsReturnArrayOfDataOnSuccess()
  {
        $this->db->expects( $this->once() )
				 ->method( 'fetch' )
				 ->will( $this->returnValue( array() ) );
 
        $this->assertInternalType( 'array', $this->object->getFriendsById( $this->user_id ) );
  }

?>