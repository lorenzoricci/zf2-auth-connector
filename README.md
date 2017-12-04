# ZF2 Authentication connector

This module manage the authentication of a user extending and using Zend Authentication

## How to import

First of all you need to import this module through the composer 

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/lorenzoricci/zf2-auth-connector.git"
    }
  ],
  "require": {
    "php": ">=5.5.0",
    "lorenzoricci/zf2-auth-connector": "dev-master"
  }
}
```

## How to use

Basically this module is emitting those events

*\Login\Event::USER_LOGGED_IN*
*\Login\Event::USER_LOGGED_OUT*
*\Login\Event::USER_REGISTERED*
*\Login\Event::USER_REGISTERED_FAILED*
*\Login\Event::USER_AUTH_FAILED*
*\Login\Event::USER_PASS_RECOVERED*
*\Login\Event::USER_PASS_RECOVER_FAILED*
*\Login\Event::USER_PASS_CHANGED*
*\Login\Event::USER_PASS_CHANGE_FAILED*

And you should attach your procedure to those. To be implementation aware I created a basic provider that you must extend with your user source: database, ldap, etc

## Example of use

You should declare a login user provider in your application config (config/autoload/global.php)

```php
return array(

    'login_user' => array(
        'provider' => 'application_user_provider'
    ),

    'service_manager' => array(
        'invokables' => array(
            'application_user_provider' => '\Application\User\Provider',
            'my_auth_service' => 'Zend\Authentication\AuthenticationService',
        ),

        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'my_auth_service',
        ),

    ),
    
);
```

and the class that will menage the correct authentication (in this case Application/User/Provider.php)

```php

namespace Application\User;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

use Zend\Authentication\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;

use \Login\Entity\User as User;
use \Login\Provider\User as UserProvider;

use Login\Action\Result as ActionResult;


class Provider extends UserProvider
{

    /**
     * Authenticate the user
     *
     * @return \Zend\Authentication\Result
     * @throws \Exception
     */
    public function authenticate()
    {
        $messages = array();

        $applicationConfig = $this->serviceManager->get('Config');
        
        //
        // Here you need to fetch your user from db, ldap, etc
        // You can use $this->username and $this->password because
        // those are the values passed  
        $User = [...];

        $EntityUser = null;

        if( $User ){

            $EntityUser = new User();

            $EntityUser->setPassword($this->password);

            // Here we add the role
            $EntityRole = new \Login\Entity\Role();
            $EntityRole->setId(1);
            $EntityRole->setRoleId("Authenticated user");

            $EntityUser->addRole($EntityRole);

            $code = AuthenticationResult::SUCCESS;
            return new AuthenticationResult($code, $EntityUser, $messages);
        }

        $code = AuthenticationResult::FAILURE;
        $messages[] = sprintf("Authentication failed for %s", $this->username );
        return new AuthenticationResult($code, '', $messages);
    }

    /**
     * Register the user
     *
     * @return Result
     * @throws \Exception
     */
    public function register($user){
        throw new \Exception("Method not implemented!");
    }

    /**
     * @param string $name
     * @param string $suggestedPassword
     * @return Result
     */
    public function recoverPassword($name, $suggestedPassword){
        throw new \Exception("Method not implemented!");
    }

    /**
     * @param mixed $data
     * @return Result
     */
    public function changePassword($data){
        throw new \Exception("Method not implemented!");
    }   
}
```

We need to attach the module emitted events to the application

```php
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;

class Module
{
   public function onBootstrap(MvcEvent $e)
   {
      $this->onUserLoginEvent( $e );
   }

   private function onUserLoginEvent( MvcEvent $e )
   {
      $eventManager        = $e->getApplication()->getEventManager();
      $sharedManager       = $eventManager->getSharedManager();

      $sharedManager->attach('*', \Login\Event::USER_LOGGED_IN, function($event) use ($e) {

         $application    = $e->getApplication();
         $sm             = $application->getServiceManager();
         $logger         = $sm->get('logger');
         $params         = $event->getParams();
         $User           = $params['User'];

         $logger->log(6, sprintf("User %s logged in.", $User->getUsername() ) ) ;

         $url = $e->getRouter()->assemble(array(), array('name' => 'application'));
         $response=$e->getResponse();
         $response->getHeaders()->addHeaderLine('Location', $url);
         $response->setStatusCode(302);
         $response->sendHeaders();
         $stopCallBack = function($event) use ($response){
         $event->stopPropagation();
            return $response;
         };
         $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack,-10000);
         return $response;
      }, 2);
   }
}
```

Good Luck!