<?php
class PaisesController extends Zend_Controller_Action
{
	
	public function init()
	{
        $this->view->controlador=$this->_request->getControllerName();
				
		if($this->_request->getParam('idioma'))
			$this->idioma=$this->_request->getParam('idioma');
		else			
			$this->idioma=DEFAULT_IDIOMA;			
			
		$locale=Zend_Registry::get('Zend_Locale');		
		$trans=Zend_Registry::get('Zend_Translate');		
		$locale->setLocale($this->idioma);
		$trans->setLocale($locale);	
		$this->view->idioma=$this->idioma;
		$this->view->headMeta()->appendName('language', $this->idioma);
		
		$this->numero_registros=5;
		$this->rango_paginas=10;
		
		$this->view->headTitle($this->view->translate("Paises"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Paises"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Paises"),'keywords');	
		
		
	}	
	
	public function indexAction()
	{	
		
		$db=Zend_Registry::get('db');

		$this->view->paises=$db->fetchAll("select * from paises ");
                               
//   		$this->view->bolivia=$db->fetRow("select * from paises where pai_id=3");		
	}
		
}
