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

use Zend\Session\SessionManager;
use Zend\Session\Container;

use Zend\Authentication\AuthenticationService;
use Zend\EventManager\Event as EventManager;

/**
 * Class User
 * @package Login\Listener
 */
class User extends AbstractListener {
	
	public function onUserLoggedIn( EventManager $e )
	{
		//$configuration  = $this->serviceLocator->get('application.config');
		//$logger         = $this->serviceLocator->get('logger');
		$params         = $e->getParams();
		$User           = $params['User'];
				
		//$this->setUserEnvironment( $User );
	}	

	public function onUserRegistered( EventManager $e )
	{
		//$configuration  = $this->serviceLocator->get('application.config');
		//$logger         = $this->serviceLocator->get('logger');
		$params         = $e->getParams();
		$User           = $params['User'];
		$Password       = $params['Password'];
			
		//$this->setUserEnvironment( $User );
	}
		
//	protected function setUserEnvironment( \Login\Entity\User $User )
//	{
//		$UserContainer = new Container('User');
//
//		$UserContainer->auth = 1;
//		$UserContainer->User = $User;
//	}
	
	public function onUserLoggedOut( EventManager $e )
	{
		$configuration         = $this->serviceLocator->get('application.config');
		$logger                = $this->serviceLocator->get('logger');
        $user_auth_service     = $this->serviceLocator->get('user_auth_service');
		$params                = $e->getParams();

        $user_auth_service->clearIdentity();
	}	
}