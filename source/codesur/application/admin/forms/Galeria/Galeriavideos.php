<?php
class Admin_Form_Galeria_Galeriavideos extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');		
		
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));

		$this->addElement('hidden','vid_id');
		//$this->addElement('hidden','gal_id');
		
//		$val_int=new Zend_Validate_Int();
//		$val_int->setMessage('Debe Escribir un Numero','notInt');
		
		$this->addElement('text','vid_titulo_es',array(
			'label'      => 'Nombre del Video(ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
$this->addElement('text','vid_titulo_en',array(
			'label'      => 'Nombre del Video (EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
        $this->addElement(new Z_Admin_Form_FileImg('vid_img',array(
			'label'			=> 'Imagen (jpg,png,gif)(550x400)',
			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));
		$this->addElement('text','vid_youtube',array(
			'label'      => 'Url de youtube ejm: http://',
			'size'		=> '60',
			'required'   => true,			
			'validators' => array('NotEmpty'),
		));	
$this->addElement('radio','vid_tipo',array(
			'label'      => 'Mostrar',
			//'required'   => true,
			'multioptions' =>array(1=>'Costado (Portada)',2=>'Abajo (Protada)',0=>'NO mostrar'),					
			//'validators' => array('NotEmpty'),
			
		));	
		$this->addElement('submit','Guardar');
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
		
	}
}
