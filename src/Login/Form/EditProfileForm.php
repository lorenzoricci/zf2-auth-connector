<?php 
namespace Login\Form;

use Zend\Form\Form;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EditProfileForm extends Form implements ServiceLocatorAwareInterface
{
	const INPUT_COL_SIZE = 'sm-8';
	const LABEL_ATTRIBUTES = 'col-sm-4'; // col-sm-3 input-lg
	const INPUT_SIZE = ''; //input-lg
		
	protected $serviceLocator;
	
	public function setServiceLocator(ServiceLocatorInterface $sl)
	{
		$this->serviceLocator = $sl;
	}
	
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}
		
	public function init()
	{		
		$formElementManager = $this->getServiceLocator();
		$mainServiceManager = $formElementManager->getServiceLocator();
		$translator = $mainServiceManager->get('translator');
		
		$this->setAttribute('method', 'post');
		
		$this->add(array(
				'name' => 'id',
				'attributes' => array(
						'type'  => 'hidden',
				),
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
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Update profile',
						'id' => 'submitbutton',
				),
		));
	}
}