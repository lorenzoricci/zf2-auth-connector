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

/**
 * Class PasswordRecoveryForm
 * @package Login\Form
 */
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