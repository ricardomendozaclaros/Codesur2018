<?php
class ElegirController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("Elegir"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Elegir"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Elegir"),'keywords');	
		
		$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{	
		
		$db=Zend_Registry::get('db');

		$this->view->tabla=$db->fetchAll("
				SELECT * 
				FROM estatico 
				WHERE est_seccion=6 
				ORDER BY est_id ASC				
				");

		
                 
            				
	}
		
}
