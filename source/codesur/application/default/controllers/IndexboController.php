<?php
class IndexboController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("Quienes Somos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Quienes Somos"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Quienes Somos"),'keywords');
		
		$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{ 	
		echo "index_bo";
		$db=Zend_Registry::get('db');
		$this->view->tabla=$db->fetchAll("
				SELECT * 
				FROM estatico 
				WHERE est_seccion=3 
				ORDER BY est_id ASC				
				");
		
		$this->view->tabla2=$db->fetchAll("
				SELECT * 
				FROM proveedores
				ORDER BY pro_orden DESC, pro_id DESC				
				");
		
		
		
		
	}
	
}
