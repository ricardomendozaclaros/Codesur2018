<?php
class Admin_Form_Administrador_Usuario extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		
		
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');
		$this->addElement('hidden','id_administrador');		
		//$this->addElement('hidden','usu_estado',array('value'=>1));
		
	/*			
		$this->addElement('text','usu_nombre',array(
			'label'      => 'Nombre',
			'size'		=> '60',
			'required'   => true,			
		));
	*/	
		
		$this->addElement('text','login',array(
			'label'      => 'Login',
			'size'		=> '60',
			'required'   => true,			
		));
		$v=new Z_Validate_Unique('administrador','login',$this->id_administrador);
		$this->login->addValidator($v);
		
		
		$this->addElement('password','pass',array(
			'label'      => 'Contraseña',
			'size'		=> '60',
			'required'   => true,			
		));
	/*	
		$this->addElement('text','usu_email',array(
			'label'      => 'email',
			'size'		=> '60',
			//'required'   => true,
			'validators'=>array('EmailAddress')			
		));
	*/
		
		
		$roles=array(
				//'experto'=>'Profesional',
                'administrador'=>'Administrador'
			
		);
		
		$identidad=Zend_Auth::getInstance()->getIdentity();
		if($identidad->rol=="jeferedactor")
			unset ($roles['administrador']);
		
		$this->addElement('select','rol',array(
			'label'      => 'Estado',			
			'required'   => true,
			'multioptions'=>$roles
		));
		
		$this->addElement('submit','Enviar');
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
	}
}
	