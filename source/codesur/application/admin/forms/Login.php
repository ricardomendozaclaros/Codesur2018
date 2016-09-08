<?php
class Admin_Form_Login extends Zend_Form {
	public function init() {
		$this->setMethod('post');
		$this->setAttrib('id', 'loginForm');
		//$this->setAction('/index/login');
		
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		//___________.|username|.___________
		$this->addElement('text','user',array(
			'label'      => 'Nombre',
			'size'		=> '32',
			'required'   => true,"class"=>"form-control",
			'validators' => array('NotEmpty'),
		));
		//$this->user->addValidator('regex',false,array('/^[a-zA-Z]+$/'));

		//___________.|password|.___________
		$this->addElement('password', 'pass', array(
			'label'      => 'Password',
			'size'		=> '32',
			'required'   => true,"class"=>"form-control",
			'validators' => array('NotEmpty'),
			'errormessages' => array('El Password no debe estar vacio')
		));
		
		$this->addElement('text','captcha',array(
			'label'      => 'Captcha',
			'size'		=> '22',
			'required'   => true,"class"=>"form-control",
			'validators' => array('NotEmpty'),
		));

		//___________.|submit|.___________
		$this->addElement('submit', 'login', array(
			'ignore'   => true,
			'label'    => 'Ingresar',
			'class'		=> ' btn btn-primary',
                         "role"=>"button"
		));
		
		
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
	}
}
/*
 * 			//'errormessage' => 'El nombre de usuario debe contener solo letras'

 */