<?php
use Framfurt\Model\Bleets\BleetsTimelineModel;

class BleetsTimelineModelTest extends PHPUnit_Framework_TestCase
{
	protected $object;
	protected $db;
	protected $cache;

	protected $user_id = 2;
	protected $items_per_page = 2;

	public function setUp()
	{
		$this->db 	 = $this->getMock( 'Framfurt\Core\Db', array( 'prepare', 'execute', 'fetchAll', 'query', 'bindParam', 'fetch' ), array(), '', false );
        $this->cache = $this->getMock( 'Framfurt\Core\Memcached', array(), array(), '', false );

		$this->object = new BleetsTimelineModel( $this->db, $this->cache );
	}

	public function testThatGetFriendsExecuteAllTheDbMethods()
	{
		$this->db->expects( $this->once() )
				 ->method( 'prepare' );

		$this->db->expects( $this->exactly( 1 ) )
				 ->method( 'bindParam' );

		$this->db->expects( $this->once() )
				 ->method( 'execute' );

		$this->db->expects( $this->once() )
				 ->method( 'fetch' );

		$this->object->getFriendsById( $this->user_id );
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

	public function testThatGetFriendsRetrievesDataFromTheCache()
	{
		$this->cache->expects( $this->once() )
					->method( 'exists' )
					->will( $this->returnValue( true ) );

		$this->cache->expects( $this->once() )
					->method( 'get' )
					->will( $this->returnValue( array() ) );

		$this->assertInternalType( 'array', $this->object->getFriendsById( $this->user_id ) );
	}

	public function testThatGetFriendsSavesOnCacheTheDbData()
	{
		$this->cache->expects( $this->once() )
					->method( 'exists' )
					->will( $this->returnValue( false ) );

		$this->cache->expects( $this->once() )
					->method( 'set' );

		$this->object->getFriendsById( $this->user_id );
	}

	public function testThatgetHomeTimlineBindsAlltheData()
	{
		$this->cache->expects( $this->at(0) )
					->method( 'exists' )
					->will( $this->returnValue( true ) );

		$this->cache->expects( $this->once() )
					->method( 'get' )
					->will( $this->returnValue( array() ) );

		$this->db->expects( $this->once() )
				 ->method( 'prepare' );

		$this->db->expects( $this->exactly(2) )
				 ->method( 'bindParam' );

		$this->db->expects( $this->once() )
				 ->method( 'execute' );

		$this->db->expects( $this->once() )
				 ->method( 'fetchAll' );

		$page = 1;

		$this->object->getHomeTimeline( $this->user_id, $page, $this->items_per_page );
	}
}