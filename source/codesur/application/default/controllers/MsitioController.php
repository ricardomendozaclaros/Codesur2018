<?php
class MsitioController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("Mapa del Sitio"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Mapa del Sitio"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Mapa del Sitio"),'keywords');
	}	
	
	public function indexAction()
	{	
		$db=Zend_Registry::get('db');
		$this->view->mapa_sitio=$db->fetchRow("
				SELECT * 
				FROM estatico 
				WHERE est_id=4");		
		
	}	
	
}
