<?php
class RecintosController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("Recintos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Recintos"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Recintos"),'keywords');

		//$this->_helper->layout()->setLayout("layout_bo");
		
		
	}	
	
	public function indexAction()
	{	
		
		$db=Zend_Registry::get('db');

		$q = $db->select()
                 ->from ('recintos')                 
               
                 ->order(array('rec_orden asc','rec_id DESC'));                
		
		
		$tabla = Zend_Paginator::factory($q);		
		$tabla	->setItemCountPerPage($this->numero_registros)
				->setPageRange($this->rango_paginas)
				->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam('pagina')));
				
		$this->view->tabla=$tabla;
            				
	}
        public function completaAction(){
          
            $alias_noticia=$this->_request->getParam('alias_recinto');
		$db=Zend_Registry::get('db');
		$this->view->noticia=$db->fetchRow("
				SELECT * 
				FROM recintos 
				WHERE rec_alias_$this->idioma=?  				
				",$alias_noticia);
				
		$this->view->headTitle($this->view->noticia['rec_titulo_'.$this->idioma],"APPEND");
        }
	
}
