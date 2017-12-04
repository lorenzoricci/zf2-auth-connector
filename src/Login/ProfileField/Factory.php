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

/**
 * This class must be fixed to allow profile field
 * structured as EAV
 */
namespace Login\ProfileField;

use Zend\Form\Element;
use Zend\Form\Form;
use Login\Entity\ProfileField as ProfileField;

/**
 * Class Factory
 * @package Login\ProfileField
 */
class Factory {

	private $_uid;
	
	public function __construct($uid){
		$this->_uid = $uid;
	}
	
	public function create( ProfileField $ProfileField ){

		switch(strtolower($ProfileField->getFieldType()))
		{
			case 'text':
				$value = $this->createTextElement( $ProfileField );
			break;
			case 'password':
				$value = $this->createPasswordElement( $ProfileField );
			break;			
			case 'select':
				$value = $this->createSelectElement( $ProfileField );
			break;			
			case 'textarea':
				$value = $this->createTextAreaElement( $ProfileField );
				break;			
			default:
				throw new \Exception($ProfileField->getFieldType(). " is not known by input factory");
			break;
		}

		if ( $ProfileField->getValue() ){
			$value->setValue( $ProfileField->getValue() );
		}
		
		return $value;
	}

	private function createPasswordElement( ProfileField $ProfileField ){
		$text = new Element\Password($ProfileField->getMachineName());
		$text->setLabel($ProfileField->getName());
		
		return $text;
	}
		
	private function createTextElement( ProfileField $ProfileField ){
		$text = new Element\Text($ProfileField->getMachineName());
		$text->setLabel($ProfileField->getName());
		return $text; 
	}	

	private function createTextAreaElement( ProfileField $ProfileField ){
		$text = new Element\Textarea($ProfileField->getMachineName());
		$text->setLabel($ProfileField->getName());
		return $text;
	}
		
	private function createSelectElement( ProfileField $ProfileField){
		$select = new Element\Select($ProfileField->getMachineName());
		$select->setLabel($ProfileField->getName());		
		$select->setEmptyOption("Select a value...");
		
		$values = array();
		if ( $ProfileField->getDefaultValues() )
			{
			$db_values= explode("|", $ProfileField->getDefaultValues());
			foreach( $db_values as $db_value)
				{	
				$splitted_value = explode(":", $db_value);
				$values[$splitted_value[0]] = $splitted_value[1];
				}
			}
						
		$select->setValueOptions($values);				
		return $select;
	}	
}