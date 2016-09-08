<?php
class Admin_Form_Contacto_Contacto extends Zend_Form {

public function init() {
	
		$decoradores = array(  
          'ViewHelper',  
          array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE)),  
     							);
     							
     	$this->setElementDecorators($decoradores);
     	
		$this->addElement('text','con_nombre',array(
			'label'			=> 'Nombre',
			'size'			=> 36,			
			'required'		=>true,
			'class' =>'formcont_txt'
		));
		
		
		$this->addElement('text','con_email',array(
			'label'			=> 'Email',
			'size'			=> 36,			
			'required'		=>false,
			'class' =>'formcont_txt'
		));
		
		$this->addElement('textarea','con_mensaje',array(
			'label'			=> 'Mensaje',
			'rows'			=> 5,
			'cols'			=> 36,			
			'class' =>'formcont_txt',
		));
		
	
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes','SafeTags','Nl2br'));
	}
}