<?php
/**
 * ZF2AuthConnector
 * Login\ACLS\ACLResult
 *
 * Created by PhpStorm.
 */


namespace Login\ACLS;


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