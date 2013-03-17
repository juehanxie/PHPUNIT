<?php

class RouterTest extends PHPUnit_Framework_TestCase
{

	protected $configuration;
	protected $url_list;
	protected $param_list;

	public function setUp()
	{
		$this->configuration = $this->getMock( 'Framfurt\Core\Configuration' );

		$this->url_list = array();
		$this->url_list[] = array(
			"pattern"	 => "store/new",
			"controller" => "Store\StoreCreateController"
		);

		$this->url_list[] = array(
			"pattern"	 => "store/delete/([0-9]+)",
			"controller" => "Store\StoreDeleteController"
		);

		$this->url_list[] = array(
			"pattern"	 => "store/update/([0-9]+)",
			"controller" => "Store\StoreUpdateController"
		);


		$this->param_list = array();
		$this->param_list['Store\StoreDeleteController'] = array( 1 => 'delete_id' );
		$this->param_list['Store\StoreUpdateController'] = array( 1 => 'store_id' );


		$map = array(
			array( "routes", $this->url_list ),
			array( "parameters", $this->param_list )
		);

		$this->configuration->expects( $this->any() )
					->method( 'load' )
					->will( $this->returnValueMap( $map ) );

	}
	public function testThatExceptionIsThrowWhenNoControllerForRoute()
	{
		$_SERVER['REQUEST_URI']    = 'no/controller/exists';
		$_SERVER['REQUEST_METHOD'] = 'GET';

		$router = new Framfurt\Core\Router( new Framfurt\Core\FilterServer, $this->configuration );

		$this->setExpectedException( 'LogicException' );

		$router->getController();
		
	}

	public function testGetNormalUriReturnsStoreController()
	{
		$_SERVER['REQUEST_URI'] = 'store/new';
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$router = new Framfurt\Core\Router( new Framfurt\Core\FilterServer, $this->configuration );

		$this->assertEquals( 'Store\StoreCreateController', $router->getController(), 'Controller must be StoreListController' );
	}

	public function testGetRegexMatchController()
	{
		$_SERVER['REQUEST_URI'] = 'store/delete/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$router = new Framfurt\Core\Router( new Framfurt\Core\FilterServer, $this->configuration );

		$this->assertEquals( 'Store\StoreDeleteController', $router->getController(), 'Controller must be StoreDeleteController' );
	}

	public function testUriWithQueryStringParameters()
	{
		$_SERVER['REQUEST_URI'] = 'store/delete/1?debug=true&mydad=false';
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$router = new Framfurt\Core\Router( new Framfurt\Core\FilterServer, $this->configuration );

		$this->assertEquals( 'Store\StoreDeleteController', $router->getController(), 'Controller must be StoreDeleteController' );
	}

	public function testControllerWithouthParametersReturnsFalse()
	{
		$_SERVER['REQUEST_URI'] = 'store/new';
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$router = new Framfurt\Core\Router( new Framfurt\Core\FilterServer, $this->configuration );
		$router->getController();

		$this->assertFalse( $router->getParameters() );
	}

	public function testcontrollerWithParametersReturnsParameters()
	{
		$_SERVER['REQUEST_URI'] = 'store/update/1';
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$router = new Framfurt\Core\Router( new Framfurt\Core\FilterServer, $this->configuration );
		$router->getController();

		$this->assertArrayHasKey( 'store_id', $router->getParameters() ); 
	}

}
