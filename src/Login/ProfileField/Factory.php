<?php
/**
 * This class must be fixed to allow profile field
 * structured as EAV
 */
namespace Login\ProfileField;

use Zend\Form\Element;
use Zend\Form\Form;
use Login\Entity\ProfileField as ProfileField;

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