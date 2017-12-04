<?php

namespace Login\Provider;

use Zend\ServiceManager\ServiceManager;

/**
 * Class TServiceManager
 *
 * Implements the required functions to be
 * ServiceManager-able
 *
 * @package Login\Provider
 */
trait TServiceManager
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager = NULL;

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

}