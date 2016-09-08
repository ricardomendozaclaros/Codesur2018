<?php
class Admin_Form_Galeria_Fotos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','fot_id');
		$this->addElement('hidden','idp');
		
		$db=Zend_Registry::get('db');		
		

$pos_portada=$db->fetchPairs('select sec_id,sec_nombre_es from fotos_seccion');	
		$this->addElement('select','sec_id',array(
			'label'      => 'Seccion',
			'required'   => true,			
			'multioptions'=>array(''=>'Selecciona una Seccion')
		));
		$this->sec_id->addMultioptions($pos_portada);
		
		
		$this->addElement('text','fot_titulo_es',array(
			'label'      => 'Nombre de la Foto(ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','fot_titulo_en',array(
			'label'      => 'Nombre de la Foto (EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('textarea','fot_descripcion_es',array(
			'label'      => 'Descripcion (ES)',
			'rows'		=> '10',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
                $this->addElement('textarea','fot_descripcion_en',array(
			'label'      => 'Descripcion (EN)',
			'rows'		=> '10',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
		//___________.|cat|
		$this->addElement(new Z_Admin_Form_FileImg('fot_img',array(
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