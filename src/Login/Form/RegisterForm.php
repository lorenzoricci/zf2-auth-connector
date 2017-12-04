<?php 
namespace Login\Form;

use Zend\Form\Form;

use Zend\InputFilter\Factory as InputFactory;     
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;   
use Zend\InputFilter\InputFilterInterface;

class RegisterForm extends Form implements InputFilterAwareInterface
{
	const INPUT_COL_SIZE = 'sm-8';
	const LABEL_ATTRIBUTES = 'col-sm-4'; // col-sm-3 input-lg
	const INPUT_SIZE = ''; //input-lg
	
	protected $inputFilter;

	
	public function __construct($name = null )
	{
		parent::__construct('register');

		$this->setAttribute('method', 'post');
        
		$this->add(array(
				'name' => 'login',				
				'options' => array(
						'label' => 'Email',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES),
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputLogin',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter your login or email'
				)
		));
		
		$this->add(array(
				'name' => 'password',				
				'options' => array(
						'label' => 'Password',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)						
				),								
				'attributes' => array(
						'type'  => 'password',
						'id' => 'inputPasswords',
						'class' => self::INPUT_SIZE,				
						'placeholder' => 'Enter your password here'						
				)
		));
		
		$this->add(array(
				'name' => 'password2',
				'options' => array(
						'label' => 'Confirm password',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)
				),
				'attributes' => array(
						'type'  => 'password',
						'id' => 'inputPasswords2',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter twice your password'
				)
		));
				
		$this->add(array(
				'name' => 'name',
				'options' => array(
						'label' => 'Company Name',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputCompanyName',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter your company name'
				)
		));

		$this->add(array(
				'name' => 'vat',
				'options' => array(
						'label' => 'Company VAT',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputCompanyVAT',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter your company VAT'
				)
		));
		
		$this->add(array(
				'name' => 'address',
				'options' => array(
						'label' => 'Address',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputCompanyAddress',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter your company address'
				)
		));

		$this->add(array(
				'name' => 'zip',
				'options' => array(
						'label' => 'Postal Code',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputCompanyZip',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter your company postal code'
				)
		));
				
		$this->add(array(
				'name' => 'city',
				'options' => array(
						'label' => 'City',
						'column-size' => self::INPUT_COL_SIZE,
						'label_attributes' => array('class' => self::LABEL_ATTRIBUTES)
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputCompanyCity',
						'class' => self::INPUT_SIZE,
						'placeholder' => 'Enter your company city'
				)
		));

		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Register to system',
						'id' => 'submitbutton',
				),
		));
		
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'login',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    new \Zend\Validator\EmailAddress(),
                    new \Login\Validator\UserAlreadyRegistered(),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 50,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'vat',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 9,
                            'max'      => 15,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'city',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 15,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'zip',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 10,
                        ),
                    ),
                    new \Zend\Validator\Digits()
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'address',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 50,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    new \Login\Validator\PasswordStrength()
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'password2',

                'validators' => array(
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'password', // name of first password field
                        ),
                    ),
                ),

            )));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}