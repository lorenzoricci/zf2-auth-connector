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
namespace Login\Form;

use Zend\Form\Form;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EditProfileForm
 * @package Login\Form
 */
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