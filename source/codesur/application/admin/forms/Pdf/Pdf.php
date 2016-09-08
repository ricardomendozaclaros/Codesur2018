<?php
class Admin_Form_Pdf_Pdf extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		
		
		$this->addElement('hidden','pdf_id');
		
		$this->addElement('text','pdf_titulo_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
		$this->addElement('text','pdf_titulo_en',array(
			'label'      => 'Nombre  (EN)',
			'size'		=> '60',
			'required'   => false,
			'validators' => array('NotEmpty'),
		));
	
		//___________.|cat|
		$this->addElement(new Z_Admin_Form_FilePdf('pdf_documento',array(
			'label'			=> 'Documento (pdf)',
			'required'		=>	true		
			//'description'	=> '[jpg,png,gif]'
		)));
			
		
	$this->addElement('radio','pdf_estado',array(
			'label'      => 'Mostrar',
			//'required'   => true,
			'multioptions' =>array(1=>'Mostrar ',0=>'NO mostrar'),					
			//'validators' => array('NotEmpty'),
			'value'=>1
		));
	
		
		$this->addElement('submit','Guardar');
		
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
		//$this->addDisplayGroup(array('estado'),'p');
	}
}