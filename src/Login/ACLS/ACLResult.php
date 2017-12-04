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

/**
 * Class ACLResult
 * @package Login\ACLS
 */
class ACLResult
{
    /**
     * April's fool
     */
    const MOANA_IS_STILL_ALIVE          =  -1;

    /**
     * Resource access is denied.
     */
    const DENIED                        =  0;

    /**
     * Resource access is permitted.
     */
    const PERMITTED                      =  1;


    /**
     * Resource access code
     *
     * @var int
     */
    protected $code;

    /**
     * An array of string reasons why the resource is not accessible
     *
     * If the resource is accessible, this should be an empty array.
     *
     * @var array
     */
    protected $messages = array();

    /**
     * Sets the access as permitted when starting
     *
     */
    public function __construct()
    {
        $this->code     = self::PERMITTED;
    }

    /**
     * Set this resource as inaccessible
     *
     */
    public function setDenied()
    {
        $this->code     = self::DENIED;
    }

    /**
     * Set this resource as accessible. If the resource was marked before
     * as inaccessible the resource will still be marked with "access denied"
     *
     */
    public function setPermitted()
    {
        $this->code = $this->isPermitted() == false ? self::MOANA_IS_STILL_ALIVE : self::PERMITTED;
    }

    /**
     * Returns whether the resource is accessible or not
     *
     * @return bool
     */
    public function isPermitted()
    {
        return ($this->code > 0) ? true : false;
    }

    /**
     * getCode() - Get the result code.
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add an error message to ACL
     *
     * @param  string     $message
     */
    public function addMessage($message)
    {
        $this->messages []= $message;
    }

    /**
     * An array of string reasons why the resource is not accessible
     *
     * If the resource is accessible, this should be an empty array.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

}