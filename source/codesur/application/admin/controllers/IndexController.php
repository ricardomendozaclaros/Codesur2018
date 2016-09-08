<?php

class Admin_IndexController extends Zend_Controller_Action {

	public function init() {

	}

	public function indexAction() {

	}

	public function cerrarsesionAction() {
		Zend_Auth::getInstance()->clearIdentity();
		Zend_Session::destroy();
		Zend_Session::stop();
		$this->_redirect('/'	);
	}
	
	public function noautorizadoAction()
	{
		$this->view->mensaje="No esta autorizado para realizar esta acción";	
	}
	
	
}

