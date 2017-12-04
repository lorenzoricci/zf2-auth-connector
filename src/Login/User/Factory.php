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