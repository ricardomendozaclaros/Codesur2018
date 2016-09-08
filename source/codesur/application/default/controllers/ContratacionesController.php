<?php
class ContratacionesController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("contrataciones"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("contrataciones"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("contrataciones"),'keywords');
		
		//$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{
	 $db=Zend_Registry::get('db');
          $nombre=$this->_request->getParam("contrataciones_alias");
      
        
         
            $pdf="select * from pdf_contrataciones where con_alias_$this->idioma='$nombre'"; 
         
            $pdf=$db->fetchRow($pdf);
            $this->view->pdf=$pdf;
        
	}

}
?>