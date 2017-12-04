<?php
/**
 * ZF2AuthConnector
 * Login\Action\Result
 *
 * Created by PhpStorm.
 */


namespace Login\Action;


class Result
{
    /**
     * General Failure
     */
    const FAILURE                        =  0;

    /**
     * Action ended successfully.
     */
    const SUCCESS                        =  1;


    /**
     * Action result code
     *
     * @var int
     */
    protected $code;

    /**
     * An array of string reasons why the operation was unsuccessful
     *
     * If everything was correct, this should be an empty array.
     *
     * @var array
     */
    protected $messages;

    /**
     * Sets the result code, and failure messages
     *
     * @param  int     $code
     * @param  array   $messages
     */
    public function __construct($code, array $messages = array())
    {
        $this->code     = (int) $code;
        $this->messages = $messages;
    }

    /**
     * Returns whether the result represents a successful action attempt
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return ($this->code > 0) ? true : false;
    }

    /**
     * getCode() - Get the result code for this action attempt
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * An array of string reasons why the operation was unsuccessful
     *
     * If everything was correct, this should be an empty array.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

}