<?php
class ProveedoresController extends Zend_Controller_Action
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
		$this->view->headTitle($this->view->translate("Proveedores"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Proveedores"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Proveedores"),'keywords');
		
		$this->numero_registros=10;
		$this->rango_paginas=10;

		
	}	
	
	public function indexAction()
	{ 			
		$db=Zend_Registry::get('db');
		$q=	$db->select()
				->from('proveedores')
				->where("pro_estado=1")
				->order(array('pro_orden DESC','pro_id DESC','pro_fecha_creacion DESC'))
		;
		
		$tabla = Zend_Paginator::factory($q);		
		$tabla	->setItemCountPerPage($this->numero_registros)
				->setPageRange($this->rango_paginas)
				->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam('pagina')));
				
		$this->view->proveedores=$tabla;
	}
	
	
}
