<?php
/**
 * Login Module
 *
 */

namespace Login\Entity;

class Role
{

    protected $id;

    protected $roleId;

    protected $parent = null;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(Role $parent)
    {
        $this->parent = $parent;
    }
}