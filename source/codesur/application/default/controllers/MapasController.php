<?php
class MapasController extends Zend_Controller_Action
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
		
		$this->view->headTitle($this->view->translate("Calendario"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Calendario"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Calendario"),'keywords');
		
		//$this->_helper->layout()->setLayout("layout_bo");
	}	
	
	public function indexAction()
	{
	//$this->_helper->layout()->setLayout("layout_mapa");	
	}
	
	public function vermapaAction() {
        //$this->_helper->layout()->setLayout("layout_mapa");
       }
	public function mapaAction() {
            $phones = array('iPhone', 'Android', 'BlackBerry');
               
                if ( preg_match('/('.implode('|', $phones).')/i', $_SERVER['HTTP_USER_AGENT']) ){
                   $this->view->mobil=true;
                   $this->_helper->layout()->setLayout("layout_mapa_mobil");   
                }else{
                   $this->view->mobil=false; 
                    $this->_helper->layout()->setLayout("layout_mapa");
                    
                }
            
        }
       
	public function pruebaAction() {
            $this->_helper->layout()->setLayout("layout_mapa_mobil");   
        
       }
    
	
	
}
?>