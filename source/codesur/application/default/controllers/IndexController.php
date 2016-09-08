<?php
class IndexController extends Zend_Controller_Action
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
		
		$this->numero_registros=10;
		$this->rango_paginas=10;
		
		
		//$this->view->headTitle($this->view->translate("Contactos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate(LEMA_SITIO),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate(LEMA_SITIO),'keywords');
	}	
	
	public function indexAction()
	{ 	
//		$this->_helper->layout()->setLayout("layout1");
//                echo "index_";
		$db=Zend_Registry::get('db');
	$this->view->principal=$db->fetchAll(" SELECT * FROM noticia WHERE not_pos =1 AND not_estado =1 ORDER BY not_fecha_creacion desc LIMIT 0 , 15 ");
		
		$this->view->historia=$db->fetchAll("SELECT * FROM historia");
	}
	
        public function completaAction(){
          
            $alias_noticia=$this->_request->getParam('alias_noticia');
		$db=Zend_Registry::get('db');
		$this->view->noticia=$db->fetchRow("
				SELECT * 
				FROM noticia 
				WHERE not_alias_$this->idioma=? AND not_estado=1 				
				",$alias_noticia);
				
		$this->view->headTitle($this->view->noticia['not_titulo_'.$this->idioma],"APPEND");
        }
 public function completaprincipalAction(){
          
            $alias_noticia=$this->_request->getParam('alias_principal');
		$db=Zend_Registry::get('db');
		$this->view->rotador=$db->fetchRow("
				SELECT * 
				FROM rotador 
				WHERE rot_alias_$this->idioma=? AND rot_estado=1 				
				",$alias_noticia);
				
		$this->view->headTitle($this->view->rotador['rot_nombre_'.$this->idioma],"APPEND");
        }
         public function masnoticiasAction(){
            $db=Zend_Registry::get('db');

            $q = $db->select()
            ->from ('noticia')  
           
            ->where("not_estado=1")
            ->order(array('not_id desc'));
            $tabla = Zend_Paginator::factory($q);		
            $tabla	->setItemCountPerPage($this->numero_registros)
            ->setPageRange($this->rango_paginas)
            ->setCurrentPageNumber(Util_Cortartexto::encontrar_pagina($this->_request->getParam('pagina')));

            $this->view->principal=$tabla;
        }
}
