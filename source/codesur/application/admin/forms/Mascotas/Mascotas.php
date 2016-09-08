<?php
class Admin_Form_Mascotas_Mascotas extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','mas_id');
	
		$this->addElement('text','mas_nombre_es',array(
			'label'      => 'Nombre de la Foto(ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','mas_nombre_en',array(
			'label'      => 'Nombre de la Foto (EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('textarea','mas_detalle_es',array(
			'label'      => 'Descripcion (ES)',
			'rows'		=> '10',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
                $this->addElement('textarea','mas_detalle_en',array(
			'label'      => 'Descripcion (EN)',
			'rows'		=> '10',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
		//___________.|cat|
		$this->addElement(new Z_Admin_Form_FileImg('mas_img',array(
			'label'			=> 'Imagen (jpg,png,gif)500x350',
			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));
			
		
		//$this->img_img->setRequired(true);	
	
		
		$this->addElement('submit','Guardar');
		
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
		//$this->addDisplayGroup(array('estado'),'p');
	}
}
