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
namespace Login\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class UserAlreadyRegistered
 *
 * Check if a user is already registered
 *
 * @todo: this is a refuse. This must be deleted from here or the user must be verified using the Provider
 *
 * @package Login\Validator
 */
class UserAlreadyRegistered extends AbstractValidator
{
    const ALREADY_REGISTERED = 'already_registered';

    /** @var array  */
    protected $messageTemplates = array(
        self::ALREADY_REGISTERED => "'%value%' is already registered. Have you lost your password?",

    );

    /**
     * @param mixed $value
     * @return bool
     */
    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        $User = \Database\Invoice\UserQuery::create()
        	->filterByLogin($value)
        	->findOne();
        
        if ( $User) {
            $this->error(self::ALREADY_REGISTERED);
            $isValid = false;
        }

        return $isValid;
    }
}