<?php

use Framfurt\Core\Events\ObserverInterface;
use Framfurt\Core\Events\EventEmitter;

class EventEmitterTest extends PHPUnit_Framework_TestCase
{
	protected $emitter;
	protected $observer;
	
	public function setUp()
	{
		$this->emitter = new EventEmitter;
		$this->observer = $this->getMock( 'TestObserver' );
	}

	public function testThatTheObserverNeverGetUpdateWhenNoEventAttached()
	{
		$this->observer->expects( $this->never() )
					   ->method( 'update' );

		$this->emitter->notify( 'event_name' );
	}

	public function testThathObserverNeverGetUpdateFromNotSubscribedEvent()
	{
		$this->observer->expects( $this->never() )
					   ->method( 'update' );

		$this->emitter->attach( $this->observer, 'notify_event' );
		$this->emitter->notify( 'not_related_event' );
	}

	public function testThathObserverGetNotifiedOncePerEvent()
	{
		$this->observer->expects( $this->once() )
				 	   ->method( 'update' );

		$this->emitter->attach( $this->observer, 'some_event' );
		$this->emitter->notify( 'some_event' );
	}

	public function testThathObserverNeverGetUpdateFromDetachedEvent()
	{
		$this->observer->expects( $this->never() )
					   ->method( 'update' );

		$this->emitter->attach( $this->observer, 'new_event' );
		$this->emitter->detach( $this->observer, 'new_event' );
		$this->emitter->notify( 'new_event' );
	}
}

Class TestObserver implements ObserverInterface
{
	public function update( $event, $data )
	{

	}
}