<?php
class IndexController extends Zend_Controller_Action
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
		
		//$this->numero_registros=10;
		//$this->rango_paginas=10;
		
		
		//$this->view->headTitle($this->view->translate("Contactos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate(LEMA_SITIO),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate(LEMA_SITIO),'keywords');
	}	
	
	public function indexAction()
	{ 	
//		$this->_helper->layout()->setLayout("layout_inicio");
//                echo "index_";
		$db=Zend_Registry::get('db');
		$this->view->principal=$db->fetchAll("SELECT * FROM noticia  where not_pos=1  ORDER BY not_orden asc ");
		
		$this->view->historia=$db->fetchAll("SELECT * FROM historia");
	}
	
        public function completaAction(){
          
            $alias_noticia=$this->_request->getParam('alias_noticia');
		$db=Zend_Registry::get('db');
		$this->view->noticia=$db->fetchRow("
				SELECT * 
				FROM noticia 
				WHERE not_alias_$this->idioma=? AND not_estado=1 				
				",$alias_noticia);
				
		$this->view->headTitle($this->view->noticia['not_titulo_'.$this->idioma],"APPEND");
        }
}
