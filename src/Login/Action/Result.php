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

namespace Login\Action;

/**
 * Class Result
 * @package Login\Action
 */
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