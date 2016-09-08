<?php
class CertificacionesController extends Zend_Controller_Action
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
		
		$this->numero_registros=4;
		$this->rango_paginas=10;
		
		$this->view->headTitle($this->view->translate("Certificaciones"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Certificaciones"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Certificaciones"),'keywords');	
		
	}	
	
	public function indexAction()
	{	
		$db=Zend_Registry::get('db');

		$q = $db->select()
                 ->from ('certificaciones')                 
                 ->where('cer_estado=1')
                 ->order(array('cer_orden DESC','cer_id DESC','cer_fecha_creacion DESC'));                
		
		
		$tabla = Zend_Paginator::factory($q);		
		$tabla	->setItemCountPerPage($this->numero_registros)
				->setPageRange($this->rango_paginas)
				->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam('pagina')));
				
		$this->view->certificaciones=$tabla;               
                 
            				
	}
		
}
