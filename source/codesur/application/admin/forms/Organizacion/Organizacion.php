<?php
class Admin_Form_Organizacion_Organizacion extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','org_id');
				
		$this->addElement('text','org_orden',array(
			'label'      => 'Importancia',
			'size'		=> '10',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
		
//		$this->addElement('text','org_titulo_es',array(
//			'label'      => 'Título (ES)',
//			'size'		=> '60',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes')				
//		));
//		
//		$this->addElement('text','org_titulo_en',array(
//			'label'      => 'Título (EN)',
//			'size'		=> '60',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes')				
//		));
				
		
		
		$this->addElement('textarea','org_descripcion_es',array(
			'label'      => 'Descripción (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
		
		$this->addElement('textarea','org_descripcion_en',array(
			'label'      => 'Descripción (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')				
		));
		
				
		
//		$this->addElement('file','org_img',array(
//			'label'			=> 'Imagen (jpg,png,gif)',
//			'required'		=>	true
//		));
//		
//		$this->org_img->setRequired(false)
//			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
//			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
//			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
//			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
				
		$this->addElement('submit','Guardar');
		
	}
}
	
?>