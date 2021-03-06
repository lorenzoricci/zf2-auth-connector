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
 * Class ACLChain
 * @package Login\ACLS
 */
class ACLChain
{
    private $_acls = array();

    public function __construct()
    {
    }

    public function addACL( IControl $acl )
    {
        $this->_acls []= $acl;
    }

    public function checkACL( $name, $event, $result )
    {
        foreach( $this->_acls as $acl )
        {
            if ( $acl::NAME == $name ){
                $acl->onACL( $name, $event, $result );
            }
            
            //if ( $acl->onACL( $name, $event, $result ) )
            //    return;

        }
    }
}