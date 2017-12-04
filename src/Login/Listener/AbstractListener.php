<?php
/**
 * This file is part of Zend Framework 2 Auth Connector (later ZF2AuthConnector).
 *
 * ZF2AuthConnector is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ZF2AuthConnector is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with ZF2AuthConnector.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      https://github.com/lorenzoricci/zf2-auth-connector source repository
 * @author    Lorenzo Ricci
 */
namespace Login\Listener;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractListener
 * @package Login\Listener
 */
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