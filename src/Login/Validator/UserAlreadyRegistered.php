<?php
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