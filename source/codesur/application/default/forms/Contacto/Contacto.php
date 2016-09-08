<?php
class Form_Contacto_Contacto extends Zend_Form {

public function init() {
	
		$decoradores = array(  
          'ViewHelper',  
          array('ViewScript', array('viewScript' => 'decoradorvacio.phtml', 'placement' => FALSE)),  
     							);
     						
     	$this->setElementDecorators($decoradores);    	
     							
     	
		$this->addElement('text','con_nombre',array(
			'label'			=> 'Nombre',
			'size'			=> 33,			
			'required'		=>true,
			'class' =>'form-control',
                         "id"=>"focusedInput"
		));		
			
                	$this->addElement('text','con_paterno',array(
			'label'			=> 'Nombre:',
			'size'			=> 35,			
			'required'		=>true,
			'class' =>'form-control',
                         "id"=>"focusedInput"
		));
	
		$this->addElement('text','con_asunto',array(
			'label'			=> 'Direccion:',
			'size'			=> 35,			
			'required'		=>true,
			'class' =>'form-control',
                         "id"=>"focusedInput"
		));

		$this->addElement('text','con_email',array(
			'label'			=> 'E-mail',
			'size'			=> 33,
			'validators'	=>array('emailAddress'),			
			'required'		=>true,
			'class' =>'form-control',
                         "id"=>"focusedInput"
		));		
	
	
		$this->addElement('textarea','con_mensaje',array(
			'label'			=> 'Ingresa tu mensaje',
			'cols'			=> 25,			
			'rows'			=> 8,
			'required'		=>false,
			'class' =>'form-control',
                         "id"=>"focusedInput"
		));	
		
			
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes','SafeTags','Nl2br'));
	}
}