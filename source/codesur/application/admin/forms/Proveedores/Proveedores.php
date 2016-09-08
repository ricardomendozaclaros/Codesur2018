<?php
class Admin_Form_Proveedores_Proveedores extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','pro_id');
		
		$this->addElement('text','pro_orden',array(
			'label'      => 'Orden',
			'size'		=> '10',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
				
		$this->addElement('text','pro_nombre_es',array(
			'label'      => 'Nombre (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','pro_nombre_en',array(
			'label'      => 'Nombre (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
				
		
		
		$this->addElement('text','pro_direccion_es',array(
			'label'      => 'Direccion (ES)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','pro_direccion_en',array(
			'label'      => 'Direccion (EN)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		
		
		$this->addElement('text','pro_fax_es',array(
			'label'      => 'Fax (ES)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','pro_fax_en',array(
			'label'      => 'Fax (EN)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		
		
		$this->addElement('text','pro_telefono_es',array(
			'label'      => 'Teléfono (ES)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','pro_telefono_en',array(
			'label'      => 'Teléfono (EN)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		
		
		$this->addElement('text','pro_email_es',array(
			'label'      => 'E-mail (ES)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		$this->addElement('text','pro_email_en',array(
			'label'      => 'E-mail (EN)',
			'size'		=> '60',
			'required'   => false,
			'filters'	=>array('StringTrim','StripSlashes')				
		));
		
		
		
		$this->addElement('file','pro_img',array(
			'label'			=> 'Imagen (jpg,png,gif)',
			'required'		=>	false
		));
		$this->pro_img->setRequired(false)
			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
		
				
		$this->addElement('submit','Guardar');
		
	}
}
	
?>