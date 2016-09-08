<?php
class VideosController extends Zend_Controller_Action
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
		$this->numero_registros=12;
		$this->rango_paginas=10;
                
		$this->view->headTitle($this->view->translate("Videos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Videos"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Videos"),'keywords');
		
		//$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{
	$db=Zend_Registry::get('db');
  
        
            $pagina=$this->_request->getParam('pagina');
       
        $q = $db->select()
                 ->from ('video')  
                ->where("vid_estado=1")
                ->order(array('vid_id asc'));
    $tabla = Zend_Paginator::factory($q);		
    $tabla->setItemCountPerPage($this->numero_registros)
          ->setPageRange($this->rango_paginas)
          ->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($pagina));
				
		$this->view->videos=$tabla;
               
	}
        public function verAction(){
            $db=Zend_Registry::get('db');
                  $alias=$this->_request->getParam('alias_video');
           
                   $video=$db->fetchRow("SELECT * FROM video WHERE vid_alias_".$this->view->idioma."=?",$alias);  
//                   var_dump($video);
                 $this->view->video=$video;
        }
	
	
	
	
	
}
?>