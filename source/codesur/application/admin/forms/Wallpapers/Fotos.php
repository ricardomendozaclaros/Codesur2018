<?php
class Admin_Form_Wallpapers_Fotos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','wal_id');
		$db=Zend_Registry::get('db');		
		

//$pos_portada=$db->fetchPairs('select sec_id,sec_nombre_es from fotos_seccion');	
//		$this->addElement('select','sec_id',array(
//			'label'      => 'Seccion',
//			'required'   => true,			
//			'multioptions'=>array(''=>'Selecciona una Seccion')
//		));
//		$this->sec_id->addMultioptions($pos_portada);
		
		
		$this->addElement('text','wal_titulo_es',array(
			'label'      => 'Nombre de la Foto(ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','wal_titulo_en',array(
			'label'      => 'Nombre de la Foto (EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('select','wal_tipo',array(
			'label'      => 'Posición',
			'multioptions'=>array(''=>'Selecciona una Opción',1=>'Desktop',2=>'Mobil',3=>'Otros'),
			'required'   => true,	
                        'value'=>1
		));
		//___________.|cat|
		$this->addElement(new Z_Admin_Form_FileImg('wal_img',array(
			'label'			=> 'Imagen (jpg,png,gif)',
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