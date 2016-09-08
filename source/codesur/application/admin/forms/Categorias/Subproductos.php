<?php
class Admin_Form_Categorias_Subproductos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','sub_id');
		
		$this->addElement('text','sub_importancia',array(
			'label'      => 'Importancia',
			'size'		=> '10',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));

		$db=Zend_Registry::get('db');
		$productos=$db->fetchPairs('		
				SELECT p.pro_id,p.pro_nombre_es
				FROM producto p
				ORDER BY pro_importancia DESC,pro_id DESC			
				');	
		
		$this->addElement('select','pro_id',array(
			'label'      => 'Producto',
			'required'   => true,			
			'multioptions'=>array(''=>'Selecciona una Opción')
		));
		$this->pro_id->addMultioptions($productos);
		
		$this->addElement('text','sub_nombre_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','sub_nombre_en',array(
			'label'      => 'Nombre (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
				
		
		
		$this->addElement('submit','Guardar');
		
	}
}
	
?>