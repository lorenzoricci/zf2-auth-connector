<?php 
namespace Login\Form;

use Zend\Form\Form;

class PasswordRecoveryForm extends Form
{
	public function __construct($name = null)
	{
		parent::__construct('passwordrecovery');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
		));
		$this->add(array(
				'name' => 'email',
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
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Recover password',
						'id' => 'submitbutton',
				),
		));
	}
}