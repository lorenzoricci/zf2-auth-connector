<?php 

namespace Login\Listener;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractListener implements EventManagerAwareInterface, ServiceLocatorAwareInterface {
	
	protected $events;
	protected $serviceLocator;
	 
	public function setEventManager(EventManagerInterface $events)
	{
		$this->events = $events;
		return $this;
	}
	 
	public function getEventManager()
	{
		if (!$this->events) {
			$this->setEventManager(new EventManager(__CLASS__));
		}
		return $this->events;
	}	

	public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
		$this->serviceLocator = $serviceLocator;
	}
	
	public function getServiceLocator() {
		return $this->serviceLocator;
	}	
}