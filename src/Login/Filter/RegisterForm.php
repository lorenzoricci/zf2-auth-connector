<?php 
namespace Login\Filter;

use Zend\InputFilter\Factory as InputFactory;     
use Zend\InputFilter\InputFilter;                 
use Zend\InputFilter\InputFilterAwareInterface;   
use Zend\InputFilter\InputFilterInterface;

class RegisterForm implements InputFilterAwareInterface
{
	
	protected $inputFilter;
	
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