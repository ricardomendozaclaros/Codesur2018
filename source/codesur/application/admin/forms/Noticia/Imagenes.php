<?php
class Admin_Form_Noticia_Imagenes extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		
		$this->addElement('hidden','img_id');
		
		$this->addElement('hidden','not_id');
//		$this->addElement('hidden','codigo');
		
		$db=Zend_Registry::get('db');		
		
                $this->addElement('text','img_orden',array(
			'label'      => 'Orden',
			'size'		=> '10',
			'required'   => true,
			//'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
//		$pos_portada=$db->fetchPairs('select img_pos_id,img_pos_nombre from noticia_img_posicion  limit 0,7');
			
		/*$this->addElement('select','img_pos_id',array(
			'label'      => 'Posición de la imagen en Portada',
			'required'   => true,			
			'multioptions'=>array(''=>'Selecciona una Opcion'),
			'filters'	=>array('StripSlashes','StringTrim')
		));
		$this->img_pos_id->addMultioptions(array(11=>'No mostrar (Solo Scroll)'));
		$this->img_pos_id->addMultioptions($pos_portada);*/
		
		
		
//		$this->addElement('select','img_pos_sec_id',array(
//			'label'      => 'Posición de la imagen en Seccion',
//			'required'   => true,			
//			'multioptions'=>array(''=>'Selecciona una Opcion'),
//			'filters'	=>array('StripSlashes','StringTrim')
//		));
//		$this->img_pos_sec_id->addMultioptions(array(11=>'No mostrar (Solo Scroll)'));
//		$this->img_pos_sec_id->addMultioptions($pos_portada);		
		
		
		$this->addElement('text','img_titulo_es',array(
			'label'      => 'Titulo (ES):',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		 	//'filters'	=>array('StripSlashes','StringTrim')
		));		
		$this->addElement('text','img_titulo_en',array(
			'label'      => 'Titulo (EN):',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		 	//'filters'	=>array('StripSlashes','StringTrim')
		));		
		//___________.|cat|
		$this->addElement(new Z_Admin_Form_FileImg('img_img',array(
			'label'			=> 'Imagen (jpg,png,gif)(900x550)',
			'required'		=>	true,		
			//'description'	=> '[jpg,png,gif]'
			//'filters'	=>array('StripSlashes','StringTrim')
		)));
			
		
		//$this->img_img->setRequired(true);	
		
		
		
//		$this->addElement('text','img_autor',array(
//			'label'      => 'Autor:',
//			'size'		=> '60',
//			'required'   => false,
//			'validators' => array('NotEmpty'),
//		 	'filters'	=>array('StripSlashes','StringTrim')
//		));
//		
//		$this->addElement('text','img_pie',array(
//			'label'      => 'Pie de foto:',
//			'size'		=> '60',
//			'required'   => false,
//			'validators' => array('NotEmpty'),
//			'filters'	=>array('StripSlashes','StringTrim')
//		));
		
		
		$this->addElement('submit','Guardar');
		
		
				
		//$this->setElementFilters(array('StringTrim','StripSlashes'));
	}
}
