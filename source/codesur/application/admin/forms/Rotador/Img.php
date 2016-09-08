<?php
class Admin_Form_Rotador_Img extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
				
		$this->addElement('hidden','rot_id');		
		
		$this->addElement('text','rot_nombre_es',array(
			'label'      => 'Nombre Rotador (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
		
		$this->addElement('text','rot_nombre_en',array(
			'label'      => 'Nombre Rotador (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
		$this->addElement('textarea','rot_descripcion_es',array(
			'label'      => 'Texto (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','rot_descripcion_en',array(
			'label'      => 'Texto (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		
		$this->addElement('text','rot_link',array(
			'label'      => 'URL completa (ej:http://www.google.com)',
			'size'		=> '60',
		//	'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
				
		
		$this->addElement(new Z_Admin_Form_FileImg('rot_img',array(
			'label'			=> 'Imagen (jpg,png,gif)(900x550)',
			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));
		
		$this->addElement('radio','rot_estado',array(
			'label'      => 'Mostrar',
			//'required'   => true,
			'multioptions' =>array(1=>'Mostrar ',0=>'NO mostrar'),					
			//'validators' => array('NotEmpty'),
			'value'=>1
		));
		$this->addElement('submit','Guardar');
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		

		
	}
}
