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

namespace Login\ACLS;

use Zend\Mvc\Controller\AbstractController;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * This class aims to check for permission looking on method annotation.
 * <code>
 * /**
 * @Login\Annotations\Security(roles={"COMPANY"})
 * * /
 * public function foo (){
 * // Your code....
 * }
 * </code>
 *
 * Class ControlMethodByAnnotation
 * @package Login\ACLS
 */
class ControlMethodByAnnotation implements IControl
{
    const NAME = 'ControlMethodByAnnotation';

    public function __construct()
    {
    }

    public function onACL($name, \Zend\Mvc\MvcEvent $e, \Login\ACLS\ACLResult $result)
    {

        if ( $result->isPermitted() == false ) {
            $result->addMessage( sprintf("Skipping %s because ACL is already set as not permitted", __FUNCTION__));
            return;
        }

        $Controller    = $e->getTarget();
        $application   = $e->getApplication();
        $sm            = $application->getServiceManager();
        $sharedManager = $application->getEventManager()->getSharedManager();
        $router        = $sm->get('router');
        $request       = $sm->get('request');
        $matchedRoute  = $router->match($request);
        $Config        = $sm->get('Config');
        $auth          = $sm->get('user_auth_service');

        // This module is not intended for console use
        if ($e->getRequest() instanceof \Zend\Console\Request) return;

        if ( $matchedRoute === null ) return;

        if ( !isset( $Config['controllers']['invokables'][$matchedRoute->getParam('controller')] )) return;

        $CheckController = $Config['controllers']['invokables'][$matchedRoute->getParam('controller')];

        $Controller = $this->startsWith($CheckController, "\\") ? $CheckController : "\\".$CheckController;

        AnnotationRegistry::registerAutoloadNamespace("Login\Annotations", __DIR__.'/../../');

        $annotationReader = new \Doctrine\Common\Annotations\AnnotationReader();

        if ( array_key_exists('zf2-auth-ignored-annotations', $Config) && !empty($Config['zf2-auth-ignored-annotations']) ){

            foreach( $Config['zf2-auth-ignored-annotations'] as $ignoredAnnotation ){
                $annotationReader->addGlobalIgnoredName($ignoredAnnotation);
            }
        }


        $MethodName     = AbstractController::getMethodFromAction( $matchedRoute->getParam('action') );

        if ( !method_exists($Controller, $MethodName) ){
            $result->addMessage("Method does not exist. Exiting...");
            return;
        }

        $reflectionMethod = new \ReflectionMethod( $Controller , $MethodName );
        $Annotations = $annotationReader->getMethodAnnotations($reflectionMethod);

        // If annotations are not present return and do not cycle;
        if( $Annotations == null ) return;

        foreach ( $Annotations as $Annotation )
        {
            if ( $Annotation instanceof \Login\Annotations\Security )
            {
                //$auth = new AuthenticationService();

                if ( !$auth->hasIdentity() ){
                    $result->setDenied();
                    $result->addMessage("Resource is marked with a security annotation and there is no identity registered");
                    return;
                }

                $Identity = $auth->getIdentity();

                if ( ($Identity instanceof \Login\Entity\User) == false  ) {
                    $result->setDenied();
                    $result->addMessage("Resource is marked with a security annotation and identity is not a known resource");
                    return;
                }

                $Roles = $Identity->getSecurityRoles();
                $AnnotatedRoles = array_map('strtoupper', $Annotation->roles);
                $containsSearch = count(array_intersect($Roles, $AnnotatedRoles));

                // Check if some role is present in user profile. If no one is found
                // the resource is not accesible
                if ( $containsSearch == 0 )
                {
                    $result->setDenied();
                    $result->addMessage("Resource is marked with a security annotation and user has not necessary permissions");
                    return false;
                }
            }
        }

        return;
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
}