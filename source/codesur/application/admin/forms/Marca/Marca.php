<?php
class Admin_Form_Marca_Marca extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','mar_id');
		
		$this->addElement('text','mar_orden',array(
			'label'      => 'Importancia',
			'size'		=> '5',
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
		
		
		
		
		
		$valida_unico_es=new Z_Validate_Unique('marca','mar_nombre_es',$this->mar_id);
		$this->addElement('text','mar_nombre_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_es)				
		));
		
		$valida_unico_en=new Z_Validate_Unique('marca','mar_nombre_en',$this->mar_id);
		$this->addElement('text','mar_nombre_en',array(
			'label'      => 'Nombre (EN)',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_en)				
		));
		
		$this->addElement('file','mar_img',array(
			'label'			=> 'Imagen (jpg,png,gif)'			
		));
		$this->mar_img->setRequired(false)
			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
		
			
		$this->addElement('text','mar_titulo_es',array(
			'label'      => 'Título (ES)',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),							
		));
		
		$this->addElement('text','mar_titulo_en',array(
			'label'      => 'Título (EN)',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),							
		));
		
			
		$this->addElement('textarea','mar_descripcion_es',array(
			'label'      => 'Descripción (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','mar_descripcion_en',array(
			'label'      => 'Descripción (EN)',
			'rows'		=> '10',
			'cols'		=> '60',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	

		
		
		
		
				
		$this->addElement('submit','Guardar');
		
	}
}
	
?>