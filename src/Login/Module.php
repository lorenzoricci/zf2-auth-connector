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
namespace Login;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Mvc\Controller\AbstractController;
use Zend\Session\SessionManager;
use Zend\Session\Container;

use Zend\Authentication\AuthenticationService;

use Doctrine\Common\Annotations\AnnotationRegistry;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $serviceManager      = $e->getApplication()->getServiceManager();
        $sharedManager       = $eventManager->getSharedManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $session = $serviceManager->get('Zend\Session\SessionManager');
        $session->start();

        $user_listener = $e->getApplication()->getServiceManager()->get('user_listener');
        $sharedManager->attach('*', \Login\Event::USER_LOGGED_IN,  array($user_listener, 'onUserLoggedIn'), 1);
        $sharedManager->attach('*', \Login\Event::USER_REGISTERED, array($user_listener, 'onUserRegistered'), 1);
        $sharedManager->attach('*', \Login\Event::USER_LOGGED_OUT, array($user_listener, 'onUserLoggedOut'), 1);
                
        $eventManager->attach('dispatch', array($this, 'loadConfiguration' ), 10);
    }

    public function loadConfiguration(MvcEvent $e)
    {
        $ACLResult = new \Login\ACLS\ACLResult();
        $ACLChain = new \Login\ACLS\ACLChain();

        $ACLChain->addACL( new \Login\ACLS\ControlByRoute() );
        $ACLChain->addACL( new \Login\ACLS\ControlClassByAnnotation() );
        $ACLChain->addACL( new \Login\ACLS\ControlMethodByAnnotation() );

        $ACLChain->checkACL( \Login\ACLS\ControlClassByAnnotation::NAME, $e, $ACLResult );
        $ACLChain->checkACL( \Login\ACLS\ControlMethodByAnnotation::NAME, $e, $ACLResult );
        $ACLChain->checkACL( \Login\ACLS\ControlByRoute::NAME, $e, $ACLResult );


//        print_r( $ACLResult->isPermitted() );
//        print_r( $ACLResult->getMessages() );
//        print_r( $ACLResult->getCode() );
//

        if ( $ACLResult->isPermitted() == false ){
            //  Assuming your login route has a name 'login', this will do the assembly
            // (you can also use directly $url=/path/to/login)
            $url = $e->getRouter()->assemble(array(), array('name' => 'login-user-login'));
            $response=$e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            // When an MvcEvent Listener returns a Response object,
            // It automatically short-circuit the Application running
            // -> true only for Route Event propagation see Zend\Mvc\Application::run

            // To avoid additional processing
            // we can attach a listener for Event Route with a high priority
            $stopCallBack = function($event) use ($response){
                $event->stopPropagation();
                return $response;
            };

            //Attach the "break" as a listener with a high priority
            $e->getApplication()->getEventManager()->attach(MvcEvent::EVENT_ROUTE, $stopCallBack,-10000);
            return $response;
        }

    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Session\SessionManager' => function ($sm) {
                    $config = $sm->get('config');
                    if (isset($config['session'])) {
                        $session = $config['session'];

                        $sessionConfig = null;
                        if (isset($session['config'])) {
                            $class = isset($session['config']['class'])  ? $session['config']['class'] : 'Zend\Session\Config\SessionConfig';
                            $options = isset($session['config']['options']) ? $session['config']['options'] : array();
                            $sessionConfig = new $class();
                            $sessionConfig->setOptions($options);
                        }

                        $sessionStorage = null;
                        if (isset($session['storage'])) {
                            $class = $session['storage'];
                            $sessionStorage = new $class();
                        }

                        $sessionSaveHandler = null;
                        if (isset($session['save_handler'])) {
                            // class should be fetched from service manager since it will require constructor arguments
                            $sessionSaveHandler = $sm->get($session['save_handler']);
                        }

                        $sessionManager = new SessionManager($sessionConfig, $sessionStorage, $sessionSaveHandler);

                        if (isset($session['validator'])) {
                            $chain = $sessionManager->getValidatorChain();
                            foreach ($session['validator'] as $validator) {
                                $validator = new $validator();
                                $chain->attach('session.validate', array($validator, 'isValid'));

                            }
                        }
                    } else {
                        $sessionManager = new SessionManager();
                    }
                    Container::setDefaultManager($sessionManager);
                    return $sessionManager;
                },
            ),
        );
    }

    public function getControllerConfig()
    {
        // Let's inject the context into controller...
        // 'Login\Controller\Profile'   => 'Login\Controller\ProfileController',
        // 'Login\Controller\Login'     => 'Login\Controller\LoginController',
        return array(
            'factories' => array(
                'Login\Controller\Login' => function ($controllers) {
                    $sm              = $controllers->getServiceLocator();
                    $appConfig       = $sm->get('Config');
                    $userProvider    = $sm->get('user_factory');
                    $authService     = $sm->get('user_auth_service');
                    $formManager     = $sm->get('FormElementManager');
                    $translator      = $sm->get('translator');

                    $controller = new \Login\Controller\LoginController($appConfig, $translator, $formManager, $authService, $userProvider);
                    return $controller;
                },
                'Login\Controller\Profile' => function ($controllers) {
                    $sm              = $controllers->getServiceLocator();
                    $appConfig       = $sm->get('Config');
                    $userProvider    = $sm->get('user_factory');
                    $authService     = $sm->get('user_auth_service');
                    $formManager     = $sm->get('FormElementManager');
                    $translator      = $sm->get('translator');

                    $controller = new \Login\Controller\ProfileController($appConfig, $translator, $formManager, $authService, $userProvider);
                    return $controller;
                },
            ),
        );
    }

}