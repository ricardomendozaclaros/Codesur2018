<?php
class Admin_Form_Historia_Historia extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
				
		$this->addElement('hidden','his_id');		
		
		$this->addElement('text','his_titulo_es',array(
			'label'      => 'Titulo (menu) (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
		
		$this->addElement('text','his_titulo_en',array(
			'label'      => 'Titulo (menu) (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
                $this->addElement('text','his_titulo_original_es',array(
			'label'      => 'Titulo  (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
		
		$this->addElement('text','his_titulo_original_en',array(
			'label'      => 'Titulo   (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
                
		
		$this->addElement('textarea','his_descripcion_es',array(
			'label'      => 'Texto (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','his_descripcion_en',array(
			'label'      => 'Texto (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		
		$this->addElement('text','his_referencia',array(
			'label'      => 'URL completa de referencia : (ej:http://www.google.com)',
			'size'		=> '60',
		//	'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
				
        for ($i=1; $i<=2; $i++){
		$this->addElement(new Z_Admin_Form_FileImg('his_img'.$i,array(
			'label'			=> 'Imagen '.$i.' (jpg,png,gif)(700x300)',
//			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));
        }
		$this->addElement('text','his_titulo_img_es',array(
			'label'      => 'Titulo (imagen) (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		
		
		$this->addElement('text','his_titulo_img_en',array(
			'label'      => 'Titulo (imagen) (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'=>	array('StringTrim','StripSlashes')		
		));
		$this->addElement('submit','Guardar');
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		

		
	}
}
