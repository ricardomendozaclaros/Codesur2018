<?php
class Admin_Form_Estatico_Estatico extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');
		$this->addElement('hidden','est_id');

		$this->addElement('text','est_importancia',array(
			'label'      => 'Importancia',
			'size'		=> '4',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));

		$this->addElement('text','est_nombre_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','est_nombre_en',array(
			'label'      => 'Nombre (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('textarea','est_contenido_es',array(
			'label'      => 'Contenido (ES)',
			'rows'		=> '25',
			'cols'		=> '60',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')			
		));		

		$this->addElement('textarea','est_contenido_en',array(
			'label'      => 'Contenido (EN)',
			'rows'		=> '25',
			'cols'		=> '60',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')			
		));				
	
		$this->addElement('submit','Guardar');
		
				
		
		
	}
}
	