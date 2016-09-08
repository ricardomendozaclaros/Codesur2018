<?php
class Admin_Form_Contacto_Datos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');
			
		$this->addElement('hidden','con_id');
		
		
		
		
		$this->addElement('textarea','con_datos_es',array(
			'label'      => 'Datos (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','con_datos_en',array(
			'label'      => 'Datos (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('text','con_email',array(
			'label'      => 'Email(s) al que se enviaran los contactos',
			'size'		=>'60',
			'validators'=>array('EmailsAddress'),
			'required'   => true,
						
		));
		
		
		
		
		
		
		$this->addElement('submit','Guardar');
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
		
	}
}
	