<?php
class ImagenesController extends Zend_Controller_Action
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
                
		$this->view->headTitle($this->view->translate("imagenes"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("imagenes"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("imagenes"),'keywords');
		
		//$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{
	//$this->_helper->layout()->setLayout("layout_1");
		
		
		$db=Zend_Registry::get('db');
            $sesion_pag=new Zend_Session_Namespace('secciones_pag');

               if($sesion_pag->sec_id){
                    $ss=$sesion_pag->sec_id;
                    $ss_titulo=$sesion_pag->sec_titulo;
                }else{
                            $sec='select * from fotos_seccion where sec_estado=1';
                            $sec=$db->fetchRow($sec);
                           $ss=$sec["sec_id"]; 
                           $ss_titulo=$sec['sec_nombre_'.$this->idioma];
                           $sesion_pag->sec_id=$ss;
                           $sesion_pag->sec_titulo=$sec['sec_nombre_'.$this->idioma];
                        } 
//                }
            
            
            
            
            $q = $db->select()
                ->from ('fotos')  
                ->where("fot_estado=1")
                ->where("sec_id=$ss")
                ->order(array('fot_id asc'));
            $tabla = Zend_Paginator::factory($q);		
            $tabla	->setItemCountPerPage($this->numero_registros)
                    ->setPageRange($this->rango_paginas)
                    ->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam('pagina')));

            $this->view->imagenes=$tabla;
		
		
	}
	
	 public function llamadaAction() {
              $db=Zend_Registry::get('db');
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $sesion_pag=new Zend_Session_Namespace('secciones_pag');
        $sec_id = $this->_request->getParam('sec_id');
        $seccc='select * from fotos_seccion where sec_estado=1 and sec_id='.$sec_id;
            $seccc=$db->fetchRow($seccc);
            $sesion_pag->sec_id=$sec_id;
            $sesion_pag->sec_titulo=$seccc['sec_nombre_'.$this->idioma];
//        $pel_llamada = $this->_request->getParam('pel_llamada');
//        $this->db->update("peluqueria_spa", array('pel_llamada' => $pel_llamada == 1 ? 2 : ($pel_llamada == 0 ? 1 : 0)), "pel_id=$pel_id");
        echo json_encode(array('ok' => true));
    }
	 public function portafolioAction() {
        $db=Zend_Registry::get('db');
     
        
        $q=$db->select()
               ->from(array('m' => 'fotos'), array('m.*'))
               ->join(array('a' => 'fotos_seccion'), 'm.sec_id = a.sec_id', array("a.*"))
               ->where("m.fot_estado=1")
               ->order("a.sec_fecha_creacion desc")
               ->group("m.sec_id");
      
        $tabla = Zend_Paginator::factory($q);		
        $tabla	->setItemCountPerPage($this->numero_registros)
        ->setPageRange($this->rango_paginas)
        ->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam('pagina')));

        $this->view->secciones=$tabla;
       
    }
	
	
}
?>