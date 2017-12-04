<?php 
namespace Login\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct($name = null )
	{
		parent::__construct('login');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
				
		$this->add(array(
				'name' => 'login',				
				'options' => array(
						'label' => 'Email',
						'column-size' => 'sm-6',
						'label_attributes' => array('class' => 'col-sm-3 input-lg')
				),
				'attributes' => array(
						'type'  => 'text',
						'id' => 'inputLogin',
						'class' => 'input-lg',
						'placeholder' => 'Enter your login or email'
				)
		));
		$this->add(array(
				'name' => 'password',				
				'options' => array(
						'label' => 'Password',
						'column-size' => 'sm-6',
						'label_attributes' => array('class' => 'col-sm-3 input-lg')						
				),								
				'attributes' => array(
						'type'  => 'password',
						'id' => 'inputPasswords',
						'class' => 'input-lg',				
						'placeholder' => 'Enter your password here'						
				)
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Login to system',
						'id' => 'submitbutton',
				),
		));
		
	}
}