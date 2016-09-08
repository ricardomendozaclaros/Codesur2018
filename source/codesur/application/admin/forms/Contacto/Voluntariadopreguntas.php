<?php
class Admin_Form_Contacto_Voluntariadopreguntas extends Zend_Form {

	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','pre_id');


//		$this->addElement('text','pre_orden',array(
//			'label'      => 'Orden',
//			'size'		=> '10',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes','Int')				
//		));
		

		$this->addElement('text','pre_titulo_es',array(
			'label'      => 'Título (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
						
		));
		$this->addElement('text','pre_titulo_en',array(
			'label'      => 'Título (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
							
		));
		$this->addElement('textarea','pre_descripcion_es',array(
			'label'      => 'Detalle (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','pre_descripcion_en',array(
			'label'      => 'Detalle (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	

		
		$this->addElement('radio','pre_estado',array(
			'label'      => 'Mostrar',
			//'required'   => true,
			'multioptions' =>array(1=>'Mostrar ',0=>'NO mostrar'),					
			//'validators' => array('NotEmpty'),
			'value'=>1
		));	
		$this->addElement('submit','Guardar');
		
	}
}
	
?>