<?php
class MascotasController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("mascotas"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Calendario"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Calendario"),'keywords');
		
		//$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{
	 $db=Zend_Registry::get('db');
          $nombre=$this->_request->getParam("alias");
      
         $sw=false;
         if($nombre=="nuna"){
           $id=1;           $sw=true;
         }
         if($nombre=="juki"){
           $id=2;           $sw=true;   
         }
         if($sw){
            $mascotas="select * from mascotas where mas_id=$id"; 
            $mascotas=$db->fetchRow($mascotas);
            $this->view->mascota=$mascotas;
         }else{
              $this->_redirect("/");   
         }
	}

}
?>