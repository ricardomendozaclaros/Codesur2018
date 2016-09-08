<?php
class Admin_LoginController extends Zend_Controller_Action 
{
	public function init() {
		
		$this->_helper->layout->setLayout('login');
		$this->db = Zend_Registry::get('db');
	}
	
	public function indexAction() {
				
		$form = new Admin_Form_Login();
		$this->view->form = $form;

		$request = $this->_request;
		if ($request->isPost()) {

			$data = $request->getPost();
			          Zend_Loader::loadClass('Securimage');
  	        $img = new Securimage();
                $captcha_valido = $img->check($data['captcha']);
//			$sesion_captcha=new Zend_Session_Namespace('captcha');
//			if($data['captcha']===$sesion_captcha->captcha)
                if($data['captcha']===$captcha_valido)
			{				
				$captcha_valido=true;	
			}
			
			if ($form->isValid($data)&&$captcha_valido) 
			{				

				$data = (object)$form->getValues();
				$auth = new Zend_Auth_Adapter_DbTable($this->db,'administrador','login','pass');
				$auth
					->setIdentity($data->user)
					->setCredential(sha1($data->pass));
					
				if($auth->authenticate()->isValid()) {
					$sesion=new Zend_Session_Namespace('unico');
					$sesion->id=substr(sha1(microtime()),0,10);
					$result = $auth->getResultRowObject(null,'pass');
					
					$this->db->update('administrador',array('ultimo_login'=>$result->fecha,'fecha'=>new Zend_Db_Expr('NOW()')),'id_administrador='.(int)$result->id_administrador);
					
					
					Zend_Auth::getInstance()->getStorage()->write($result);
					$this->view->navigation()->setRole($result->rol);
					$this->_redirect('/admin');
				}
			}
			else
				$form->captcha->setValue('');
		}
	}
}
