<?php

abstract class AbstractController extends PHPUnit_Framework_TestCase
{
	protected $object;

	protected $server;
	protected $get;
	protected $post;
	protected $files;
	protected $event;
	protected $cache;
	protected $view;
	protected $registry;
	protected $header;
	protected $core;
	protected $configuration;
	protected $session;

	protected $mocked;

	protected function preMockDependencies()
	{
		$this->server 			= $this->getMock( 'Framfurt\Core\FilterServer', array(), array(), '', false );
		$this->get 				= $this->getMock( 'Framfurt\Core\FilterGet', array(), array(), '', false );
		$this->post 			= $this->getMock( 'Framfurt\Core\FilterPost', array(), array(), '', false );
		$this->files 			= $this->getMock( 'Framfurt\Core\FilterFiles', array(), array(), '', false );
		$this->event 			= $this->getMock( 'Framfurt\Core\Events\EventEmitter', array(), array(), '', false );
		$this->cache 			= $this->getMock( 'Framfurt\Core\Cache', array(), array(), '', false );
		$this->registry 		= $this->getMock( 'Framfurt\Core\ModelRegistry', array(), array(), '', false );
		$this->view 			= $this->getMock( 'Framfurt\Core\View', array(), array(), '', false );
		$this->header 			= $this->getMock( 'Framfurt\Core\Header', array(), array(), '', false );
		$this->core				= $this->getMock( 'Framfurt\Core\CoreFactory', array(), array(), '', false );
		$this->configuration 	= $this->getMock( 'Framfurt\Core\Configuration', array(), array(), '', false );
		$this->session 			= $this->getMock( 'Framfurt\Core\Session', array(), array(), '', false );

		$this->mocked = 1;
	}

	protected function mockController( $controller_name )
	{
		if ( ! $this->mocked )
		{
			$this->preMockDependencies();
		}

		$this->object = new $controller_name(
			$this->server,
			$this->get,
			$this->post,
			$this->files,
			$this->view,
			$this->registry,
			$this->event,
			$this->cache,
			$this->header,
			$this->core,
			$this->configuration,
			$this->session
		);
	}
}

