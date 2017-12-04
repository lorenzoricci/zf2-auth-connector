<?php
/**
 * ZF2AuthConnector
 *
 * Login\ACLS\ACLChain
 *
 */


namespace Login\ACLS;


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