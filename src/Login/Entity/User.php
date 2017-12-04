<?php
/**
 * Login Module
 */

namespace Login\Entity;

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