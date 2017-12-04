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
namespace Login\Provider;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Login\Action\Result;
use Zend\Authentication\Adapter\AbstractAdapter;

/**
 * Class User
 *
 * This class is an abstract for interacting with
 * Zend Framework. Here we create a ServiceManager-able
 * class that will be implemented inside the consuming
 * application.
 *
 * Note: I decided to broke BC with version 5.3.3 of
 *  PHP starting using traits.
 *
 * @package Login\Provider
 */
abstract class User
    extends AbstractAdapter implements ServiceManagerAwareInterface
{

    use TServiceManager;

    /* @var string */
    protected $username;

    /* @var string */
    protected $password;

    /**
     * @param string $name
     * @param string $suggestedPassword
     * @return Result
     */
    abstract public function recoverPassword($name, $suggestedPassword);

    /**
     * @param mixed $data
     * @return Result
     */
    abstract public function changePassword($data);

    /**
     * @param mixed $user
     * @return Result
     */
    abstract public function register($user);

    /**
     * @return mixed
     */
    abstract public function getUser();

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Provider
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Provider
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}