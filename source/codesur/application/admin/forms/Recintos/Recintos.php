<?php
class Admin_Form_Recintos_Recintos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','rec_id');
		

		$this->addElement('text','rec_orden',array(
			'label'      => 'Orden',
			'size'		=> '10',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
		

		
		$valida_unico_es=new Z_Validate_Unique('receta','rec_titulo_es',$this->rec_id);
		$this->addElement('text','rec_titulo_es',array(
			'label'      => 'Título (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_es)					
		));
		
		$valida_unico_en=new Z_Validate_Unique('receta','rec_titulo_en',$this->rec_id);
		$this->addElement('text','rec_titulo_en',array(
			'label'      => 'Título (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_en)				
		));
		$this->addElement('text','rec_deporte_es',array(
			'label'      => 'Tipo de Deporte  (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
		));
		
	
		$this->addElement('text','rec_deporte_en',array(
			'label'      => 'Tipo de Deporte  (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
		));
		$this->addElement('text','rec_direccion_es',array(
			'label'      => 'Direccion (ES)',
'size'		=> '60',
//			'cols'		=> '70',
			//'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('text','rec_direccion_en',array(
			'label'      => 'Direccion (EN)',
'size'		=> '60',
//			'cols'		=> '70',
			//'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		
		
		$this->addElement('textarea','rec_descripcion_es',array(
			'label'      => 'Cuerpo (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','rec_descripcion_en',array(
			'label'      => 'Cuerpo (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('text','rec_google_map',array(
			'label'      => 'Google map(iframe)',
'size'		=> '60',
//			'cols'		=> '70',
//			'class'		=> 'tinymce',
			'required'   => true,
			//'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
		
		$this->addElement('file','rec_img',array(
			'label'			=> 'Imagen (jpg,png,gif)(580x250)',
		));
		
		$this->rec_img->setRequired(false)
			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
		
				
		$this->addElement('submit','Guardar');
		
	}
}
	
?>