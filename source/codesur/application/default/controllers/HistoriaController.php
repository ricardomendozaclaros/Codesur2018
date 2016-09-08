<?php
class HistoriaController extends Zend_Controller_Action
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
		
		$this->numero_registros=6;
		$this->rango_paginas=10;
		
		$this->view->headTitle($this->view->translate("Historia"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Historia"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Historia"),'keywords');

		//$this->_helper->layout()->setLayout("layout_bo");
		
		
	}	
	
	
        public function indexAction(){
          
            $alias_noticia=$this->_request->getParam('alias_historia');
		$db=Zend_Registry::get('db');
		$this->view->noticia=$db->fetchRow("
				SELECT * 
				FROM historia 
				WHERE his_alias_$this->idioma=?  				
				",$alias_noticia);
				
		$this->view->headTitle($this->view->noticia['his_titulo_original_'.$this->idioma],"APPEND");
        }
	
}
