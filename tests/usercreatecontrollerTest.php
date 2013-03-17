<?php
use Framfurt\Controller\User\UserCreateController;

require_once( 'controller.php' );


class UserCreateControllerTest extends AbstractController
{
	protected $object;
	protected $view;
	protected $strategy;

	public function setUp()
	{
		$this->mockController( 'Framfurt\Controller\User\UserCreateController' );
	}



	public function testThatHaveNotDataInControllerPost()
	{
		$this->post->expects( $this->once() )
		->method( 'haveData' )
		->will( $this->returnValue( false ));
		$this->object->init();
	}

	public function testThatSetCreateTemplateInTheView()
	{
		$this->view->expects( $this->once() )
		->method( 'setTemplate' )
		->with( $this->logicalOr(
			$this->stringContains( 'user/create' )
			));
		$this->object->init();
	}

	public function testThatHaveDataInControllerPostAndRedirectToUserValidationPage()
	{

		$values = array( 
			array( 'user_name' , 'jorge' ),
			array( 'nick' , 'jorge' ),
			array( 'email' , 'jorge@jorge.com' ),
			array( 'password' , 'jorge' ),
			array( 'repassword' , 'jorge' )
		 );
		$this->post->expects( $this->once() )
					->method( 'haveData' )
					->will( $this->returnValue( true ) );

		$this->post->expects( $this->exactly( 5 ) )
					->method( 'getText' )
					->will( $this->returnValueMap( $values ) );


		$encrypterfactory	= $this->getMock( 'Framfurt\Core\EncrypterFactory', array(), array(), '', false );
		$modelfactory		= $this->getMock( 'Framfurt\Core\ModelFactory', array(), array(), '', false );
		$user				= $this->getMock( 'Framfurt\Model\User\UserUserModel', array( 'insertUser' ), array(), '', false );
		$avatar				= $this->getMock( 'Framfurt\Model\User\UserAvatarModel', array(), array(), '', false );

		$modelmap = array(
			array( 'UserUser', $this->event, null, $user ),
			array( 'UserAvatar', $this->event, null, $avatar ),
			);

		$map = array(
			array( 'ModelFactory', $modelfactory ),
			array( 'EncrypterFactory', $encrypterfactory )
			);

		$user->expects( $this->any() )
			->method( 'insertUser' )	
			->will( $this->returnValue( true ) );

		$modelfactory->expects( $this->any() )
			->method( 'getClass' )	
			->will( $this->returnValueMap( $modelmap ) );


		$this->core->expects( $this->any() )
					->method( 'getClass' )
					->will( $this->returnValueMap( $map ) );

		$this->header->expects( $this->any() )
			->method( 'setHeader' )
			->with( 'Location: /new-user-validation' );

		$this->object->init();
	}

	public function testThatHaveDataInControllerPostAndRedirectToNewUserFormBecauseAModelReturnsFalse()
	{

		$values = array( 
			array( 'user_name' , 'jorge' ),
			array( 'nick' , 'jorge' ),
			array( 'email' , 'jorge@jorge.com' ),
			array( 'password' , 'jorge' ),
			array( 'repassword' , 'jorge' )
		 );
		$this->post->expects( $this->once() )
					->method( 'haveData' )
					->will( $this->returnValue( true ) );

		$this->post->expects( $this->exactly( 5 ) )
					->method( 'getText' )
					->will( $this->returnValueMap( $values ) );


		$encrypterfactory	= $this->getMock( 'Framfurt\Core\EncrypterFactory', array(), array(), '', false );
		$modelfactory		= $this->getMock( 'Framfurt\Core\ModelFactory', array(), array(), '', false );
		$user				= $this->getMock( 'Framfurt\Model\User\UserUserModel', array( 'insertUser' ), array(), '', false );
		$avatar				= $this->getMock( 'Framfurt\Model\User\UserAvatarModel', array(), array(), '', false );

		$modelmap = array(
			array( 'UserUser', $this->event, null, $user ),
			array( 'UserAvatar', $this->event, null, $avatar ),
			);

		$map = array(
			array( 'ModelFactory', $modelfactory ),
			array( 'EncrypterFactory', $encrypterfactory )
			);

		$user->expects( $this->any() )
			->method( 'insertUser' )	
			->will( $this->returnValue( false ) );

		$modelfactory->expects( $this->any() )
			->method( 'getClass' )	
			->will( $this->returnValueMap( $modelmap ) );


		$this->core->expects( $this->any() )
					->method( 'getClass' )
					->will( $this->returnValueMap( $map ) );

		$this->header->expects( $this->any() )
			->method( 'setHeader' )
			->with( 'Location: /new-user' );

		$this->object->init();
	}

	public function testThatHaveDataInControllerPostAndRedirectToNewUserFormBecauseAModelReturnsFalseWithAvatar()
	{

		$values = array( 
			array( 'user_name' , 'jorge' ),
			array( 'nick' , 'jorge' ),
			array( 'email' , 'jorge@jorge.com' ),
			array( 'password' , 'jorge' ),
			array( 'repassword' , 'jorge' )
		 );
		$this->post->expects( $this->once() )
					->method( 'haveData' )
					->will( $this->returnValue( true ) );

		$this->post->expects( $this->exactly( 5 ) )
					->method( 'getText' )
					->will( $this->returnValueMap( $values ) );


		$encrypterfactory	= $this->getMock( 'Framfurt\Core\EncrypterFactory', array(), array(), '', false );
		$modelfactory		= $this->getMock( 'Framfurt\Core\ModelFactory', array(), array(), '', false );
		$user				= $this->getMock( 'Framfurt\Model\User\UserUserModel', array( 'insertUser' ), array(), '', false );
		$avatar				= $this->getMock( 'Framfurt\Model\User\UserAvatarModel', array( 'uploadImage' ), array(), '', false );

		$avatar->expects( $this->once() )
				->method( 'uploadImage' )
				->will( $this->returnVAlue( 'myimage.jpg' ) );

		$this->files->expects( $this->once() )
				->method( 'getAllInfo' )
				->will( $this->returnVAlue( array( 'tmp_name' => 'temporalname.extension' ) ) );

		$modelmap = array(
			array( 'UserUser', $this->event, null, $user ),
			array( 'UserAvatar', $this->event, null, $avatar ),
			);

		$map = array(
			array( 'ModelFactory', $modelfactory ),
			array( 'EncrypterFactory', $encrypterfactory )
			);

		$user->expects( $this->any() )
			->method( 'insertUser' )	
			->will( $this->returnValue( false ) );

		$modelfactory->expects( $this->any() )
			->method( 'getClass' )	
			->will( $this->returnValueMap( $modelmap ) );


		$this->core->expects( $this->any() )
					->method( 'getClass' )
					->will( $this->returnValueMap( $map ) );

		$this->header->expects( $this->any() )
			->method( 'setHeader' )
			->with( 'Location: /new-user' );

		$this->object->init();
	}

}