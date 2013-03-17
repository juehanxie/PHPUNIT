<?php

require_once 'controller.php';

class HomeControllerTest extends AbstractController
{
	public function setUp()
	{
		$this->mockController( 'Framfurt\Controller\Home\HomeHomeController' );

		$this->bleetform_mock = $this->getMockBuilder( 'Framfurt\Controller\Shared\SharedBleetformController' )
							   ->disableOriginalConstructor()
							   ->getMock();

		$this->timeline = $this->getMockBuilder( 'Framfurt\Controller\Shared\SharedTimelineController' )
						 ->disableOriginalConstructor()
						 ->getMock();


		$controller_factory_mock = $this->getMock( 'Framfurt\Core\ControllerFactory' );

		$view_mock = $this->getMock( 'Framfurt\Core\View', 
											array(), 
											array(), 
											'', 
											false);

		$view_factory_mock = $this->getMock( 'Framfurt\Core\ViewFactory' );
		

		$factory_map = array(
			array( 'ControllerFactory', $controller_factory_mock ),
			array( 'ViewFactory', $view_factory_mock ),

		);

		$controller_map = array(
			array( 'Shared\SharedBleetformController', $this->server, $this->get, $this->post, $this->files, $view_mock, $this->registry, $this->event, $this->cache, $this->header, $this->core, $this->configuration, $this->session, $this->bleetform_mock ),
			array( 'Shared\SharedTimelineController', $this->server, $this->get, $this->post, $this->files, $view_mock, $this->registry, $this->event, $this->cache, $this->header, $this->core, $this->configuration, $this->session, $this->timeline )
		);

		$view_map = array(
			array( 'twig', $this->event, $view_mock )
		);

		$this->core->expects( $this->any() )
				   ->method( 'getClass' )
				   ->will( $this->returnValueMap( $factory_map ) );

		$view_factory_mock->expects( $this->any() )
					  ->method( 'getClass' )
					  ->will( $this->returnValueMap( $view_map ) );
		
		$controller_factory_mock->expects( $this->any() )
					  ->method( 'getClass' )
					  ->will( $this->returnValueMap( $controller_map ) );
	}

	public function testThatHomeHomeControllerInitDoesNotThrowAnException()
	{
		$this->bleetform_mock->expects( $this->once() )
							 ->method( 'init' );

		$this->object->init();
	}

	public function testThatInitAssignModules()
	{
		$this->view->expects( $this->exactly( 2 ) )
				   ->method( 'assign' );

		$this->object->init();
	}
}