<?php
namespace Login\User;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\ServiceManager\Exception\ServiceNotCreatedException;

/**
 * User Factory
 *
 * This factory fetch the provider implemented inside
 * the consuming app
 *
 * @package Login\User
 */
class Factory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return \Login\Provider\User
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $p = null;

        try {
                $p = $serviceLocator->get($config['login_user']['provider']);
        } catch (\Exception $Exception) {
            throw new \Exception( sprintf("Unable to use the selected user provider. Details: %s", $Exception->getMessage() ) );

        }

        return $p;
    }
}