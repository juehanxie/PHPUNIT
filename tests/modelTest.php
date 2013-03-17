<?php

abstract class ModelTest extends PHPUnit_Framework_TestCase
{
	protected $object;

	protected $db;
	protected $cache;

	protected function mockModel( $model_name )
	{
		$this->db = $this->getMockBuilder( 'Framfurt\Core\Db' )
						->disableOriginalConstructor()
						->getMock();

		$this->cache = $this->getMockBuilder( 'Framfurt\Core\Cache' )
							->disableOriginalConstructor()
							->getMock();

		$this->object = new $model_name( $this->db, $this->cache );
	}
}