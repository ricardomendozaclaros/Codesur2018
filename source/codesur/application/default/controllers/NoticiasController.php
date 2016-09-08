<?php
class NoticiasController extends Zend_Controller_Action
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
		$this->view->headTitle($this->view->translate("Noticias"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Noticias"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Noticias"),'keywords');
		
		
		$this->numero_registros=4;
		$this->rango_paginas=10;
		
		
	}	
	
	public function indexAction()
	{ 	
		
		$db=Zend_Registry::get('db');		
		$q = $db->select()
                 ->from ('noticia')                 
                 ->where('not_estado=1 AND not_pos=1')
                 ->order(array('not_orden DESC','not_id DESC','not_fecha_creacion DESC'));                
		
		
		$tabla = Zend_Paginator::factory($q);		
		$tabla	->setItemCountPerPage($this->numero_registros)
				->setPageRange($this->rango_paginas)
				->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam("pagina")));
				
		$this->view->secundaria=$tabla;
	}
	
	public function noticiaAction()
	{ 			
		$alias_noticia=$this->_request->getParam('alias_noticia');
		$db=Zend_Registry::get('db');
		$this->view->noticia=$db->fetchRow("
				SELECT * 
				FROM noticia 
				WHERE not_alias_$this->idioma=? AND not_estado=1 AND not_pos=1				
				",$alias_noticia);
				
		$this->view->headTitle($this->view->noticia['not_titulo_'.$this->idioma],"APPEND");
	}
	
}
