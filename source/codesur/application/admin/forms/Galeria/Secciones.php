<?php
class Admin_Form_Galeria_Secciones extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','sec_id');
//		$this->addElement('hidden','idp');
		
//		$db=Zend_Registry::get('db');		
		

//		$pos_portada=$db->fetchPairs('select gal_id,gal_nombre from galeria where gal_tipo=1');	
//		$this->addElement('select','gal_id',array(
//			'label'      => 'Galeria',
//			'required'   => true,			
//			'multioptions'=>array(''=>'Selecciona una Galeria')
//		));
//		$this->gal_id->addMultioptions($pos_portada);
		
		
		$this->addElement('text','sec_nombre_es',array(
			'label'      => 'Nombre ',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','sec_nombre_en',array(
			'label'      => 'Nombre ',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
//		$this->addElement('textarea','sec_descripcion_es',array(
//			'label'      => 'Descripcion (ES)',
//			'rows'		=> '10',
//			'cols'		=> '70',
//			'class'		=> 'tinymce',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
//		));
//                $this->addElement('textarea','sec_descripcion_en',array(
//			'label'      => 'Descripcion (EN)',
//			'rows'		=> '10',
//			'cols'		=> '70',
//			'class'		=> 'tinymce',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
//		));
		//___________.|cat|
//		$this->addElement(new Z_Admin_Form_FileImg('sec_img',array(
//			'label'			=> 'Imagen (jpg,png,gif)500x350',
//			'required'		=>	true		
//			//'description'	=> '[jpg,png,gif]'
//		)));
			
		
		//$this->img_img->setRequired(true);	
	
		
		$this->addElement('submit','Guardar');
		
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
		//$this->addDisplayGroup(array('estado'),'p');
	}
}
