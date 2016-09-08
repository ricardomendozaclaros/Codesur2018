<?php
class Admin_Form_Marca_Presentacion extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','pre_id');
		$this->addElement('hidden','idp');
		
		$this->addElement('text','pre_orden',array(
			'label'      => 'Importancia',
			'size'		=> '5',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
		
		$db=Zend_Registry::get('db');
		$marcas=$db->fetchPairs('		
				SELECT m.mar_id,m.mar_nombre_es
				FROM marca m
				ORDER BY m.mar_orden DESC,mar_id DESC			
				');	
		
		$this->addElement('select','mar_id',array(
			'label'      => 'Marca',
			'required'   => true,			
			'multioptions'=>array(''=>'Selecciona una Opción')
		));
		$this->mar_id->addMultioptions($marcas);
		
		
		
		
		
		$valida_unico_es=new Z_Validate_Unique('presentacion','pre_nombre_es',$this->pre_id);
		$this->addElement('text','pre_nombre_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_es)				
		));
		
		$valida_unico_en=new Z_Validate_Unique('presentacion','pre_nombre_en',$this->mar_id);
		$this->addElement('text','pre_nombre_en',array(
			'label'      => 'Nombre (EN)',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_en)				
		));
		
		
		$this->addElement('textarea','pre_descripcion_es',array(
			'label'      => 'Descripción (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','pre_descripcion_en',array(
			'label'      => 'Descripción (EN)',
			'rows'		=> '10',
			'cols'		=> '60',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		
		$this->addElement('textarea','pre_registros_es',array(
			'label'      => 'Registros (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','pre_registros_en',array(
			'label'      => 'Registros (EN)',
			'rows'		=> '10',
			'cols'		=> '60',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		
		
		$this->addElement('text','pre_items',array(
			'label'      => 'Items',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		
		$this->addElement('text','pre_peso',array(
			'label'      => 'Peso',
			'size'		=> '50',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('file','pre_img',array(
			'label'			=> 'Imagen (jpg,png,gif)'			
		));
		
		
		
		$this->pre_img->setRequired(false)
			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
		
		
		
		$this->addElement('file','pre_etiqueta',array(
			'label'			=> 'Etiqueta (jpg,png,gif)'			
		));
		
		
		
		$this->pre_etiqueta->setRequired(false)
			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
		
		
		
		
				
		$this->addElement('submit','Guardar');
		
	}
}
	
?>