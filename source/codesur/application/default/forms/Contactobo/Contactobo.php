<?php
class Form_Contactobo_Contactobo extends Zend_Form {

public function init() {
	
		$decoradores = array(  
          'ViewHelper',  
          array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE)),  
     							);
     						
     	$this->setElementDecorators($decoradores);    	
     							
     	
		$this->addElement('text','con_nombre',array(
			'label'			=> 'Nombre',
			'size'			=> 33,			
			'required'		=>true,
			'class' =>'con_form_input con_round requerido'
		));		
		
		$this->addElement('text','con_email',array(
			'label'			=> 'E-mail',
			'size'			=> 33,
			'validators'	=>array('emailAddress'),			
			'required'		=>true,
			'class' =>'con_form_input con_round requerido',
		));		
	
	
		$this->addElement('textarea','con_mensaje',array(
			'label'			=> 'Ingresa tu mensaje',
			'cols'			=> 25,			
			'rows'			=> 8,
			'required'		=>true,
			'class' =>'con_form_txt con_round requerido',
		));	
		
			
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes','SafeTags','Nl2br'));
	}
}