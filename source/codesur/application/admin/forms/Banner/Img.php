<?php
class Admin_Form_Banner_Img extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','ban_id');		
		$this->addElement('hidden','ban_tipo',array('value'=>1));
		
		
		$db=Zend_Registry::get('db');
		$pos_banner=$db->fetchPairs('		
				SELECT p.pos_id,p.pos_nombre,count(b.ban_id),p.pos_max_items
				FROM banner_posicion p
				LEFT JOIN banner b ON p.pos_id=b.pos_id 
				WHERE p.pos_max_items>0				
				GROUP BY p.pos_id				
				HAVING (p.pos_max_items>count(b.ban_id))
				ORDER BY pos_id			
				');	
		
		
		$this->addElement('select','pos_id',array(
			'label'      => 'Posición del Banner',
			'required'   => true,			
			'multioptions'=>array(''=>'Selecciona una Opción')
		));
		$this->pos_id->addMultioptions($pos_banner);
		
		
		
		$this->addElement('text','ban_nombre_es',array(
			'label'      => 'Nombre Banner (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
		/*
		$this->addElement('text','ban_nombre_en',array(
			'label'      => 'Nombre Banner (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));*/
		
		
		
		$this->addElement('text','ban_url',array(
			'label'      => 'URL completa (ej:http://www.google.com)',
			'size'		=> '60',
		//	'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
				
		
		$this->addElement(new Z_Admin_Form_FileImg('ban_img_es',array(
			'label'			=> 'Imagen (jpg,png,gif) (ES)',
			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));
		/*
		$this->addElement(new Z_Admin_Form_FileImg('ban_img_en',array(
			'label'			=> 'Imagen (jpg,png,gif) (EN)',
			'required'		=>	true
		)));*/
			
		
		
		$this->addElement('submit','Guardar');
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		

		
	}
}
