<?php
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