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
namespace Login\Entity;

/**
 * Class User
 * @package Login\Entity
 */
class User
{ 
    protected $id;
    protected $username;
    protected $email;
    protected $displayName;
    protected $password;
    protected $state;
    protected $roles = array() ;
    
    protected $security_roles = array() ;
    
    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }


    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
        $this->security_roles []= strtoupper($role->getRoleId());
    }
    
    public function getSecurityRoles()
    {
		return $this->security_roles;
    }

    public function hasRole( $name )
    {
		return in_array( strtoupper($name), $this->security_roles ); 
    }
}