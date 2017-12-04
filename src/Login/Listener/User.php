<?php
namespace Login\Listener;

use Zend\Session\SessionManager;
use Zend\Session\Container;

use Zend\Authentication\AuthenticationService;
use Zend\EventManager\Event as EventManager;

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