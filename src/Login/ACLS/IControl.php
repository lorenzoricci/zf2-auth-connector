<?php
/**
 * ZF2AuthConnector
 *
 * Login\ACLS\IControl
 *
 */

namespace Login\ACLS;


interface IControl
{
    public function onACL($name, \Zend\Mvc\MvcEvent $e, \Login\ACLS\ACLResult $result);
}