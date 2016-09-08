<?php
class Admin_Form_Deportes_Deportes extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));

		$this->addElement('hidden','dep_id');
		$this->addElement('hidden','idp');
		
		$db=Zend_Registry::get('db');		

		$this->addElement('text','dep_titulo_es',array(
			'label'      => 'Titulo (ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','dep_titulo_en',array(
			'label'      => 'Titulo (EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('textarea','dep_detalle_es',array(
			'label'      => 'Descripcion (ES)',
			'rows'		=> '10',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
                $this->addElement('textarea','dep_detalle_en',array(
			'label'      => 'Descripcion (EN)',
			'rows'		=> '10',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));
                for($i=1;$i<=2;$i++){
                    if($i==1){$tamanio="900x300";}else{$tamanio="170x175";}
                 $this->addElement(new Z_Admin_Form_FileImg('dep_img'.$i,array(
			'label'			=> 'Imagen '. $i.' (jpg,gif)'.$tamanio,
			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));   
                }
//		$this->addElement(new Z_Admin_Form_FileImg('dep_img',array(
//			'label'			=> 'Imagen (jpg,png,gif)900x300',
//			'required'		=>	true		
//			//'description'	=> '[jpg,png,gif]'
//		)));
			
		$this->addElement('radio','dep_estado',array(
			'label'      => 'Mostrar',
			//'required'   => true,
			'multioptions' =>array(1=>'Mostrar ',0=>'NO mostrar'),					
			//'validators' => array('NotEmpty'),
			'value'=>1
		));
		//$this->img_img->setRequired(true);	
	
		
		$this->addElement('submit','Guardar');
		
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
		//$this->addDisplayGroup(array('estado'),'p');
	}
}