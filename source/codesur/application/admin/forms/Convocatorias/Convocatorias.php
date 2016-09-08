<?php
class Admin_Form_Convocatorias_Convocatorias extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','con_id');
		
		
		$db=Zend_Registry::get('db');		
		

//		$pos_portada=$db->fetchPairs('select gal_id,gal_nombre from galeria where gal_tipo=1');	
//		$this->addElement('select','gal_id',array(
//			'label'      => 'Galeria',
//			'required'   => true,			
//			'multioptions'=>array(''=>'Selecciona una Galeria')
//		));
//		$this->gal_id->addMultioptions($pos_portada);
		
		
		$this->addElement('text','con_titulo_es',array(
			'label'      => 'Nombre del Pdf(ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','con_titulo_en',array(
			'label'      => 'Nombre del Pdf(EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		
		//___________.|cat|
		$this->addElement(new Z_Admin_Form_FilePdf('con_pdf',array(
			'label'			=> 'Imagen (pdf)',
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
