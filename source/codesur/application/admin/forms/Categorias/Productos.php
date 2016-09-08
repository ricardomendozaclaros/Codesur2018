<?php
class Admin_Form_Categorias_Productos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','pro_id');
		
		$this->addElement('text','pro_importancia',array(
			'label'      => 'Importancia',
			'size'		=> '10',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
				
		$this->addElement('text','pro_nombre_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','pro_nombre_en',array(
			'label'      => 'Nombre (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
				
		
		
		$this->addElement('submit','Guardar');
		
	}
}
	
?>