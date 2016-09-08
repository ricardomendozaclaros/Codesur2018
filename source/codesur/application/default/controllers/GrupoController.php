<?php
class GrupoController extends Zend_Controller_Action
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
		$this->view->headTitle($this->view->translate("GRUPO COMPANEX"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("GRUPO COMPANEX"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("GRUPO COMPANEX"),'keywords');
		
		
		/*aqui consulta de banner que corresponda*/
		$this->view->banner_costado=array('ban_nombre'=>'banner_supra.jpg');	
		
	}	
	
	public function indexAction()
	{	
		$db=Zend_Registry::get('db');	
		$alias_grupo=$this->_request->getParam("alias_grupo");
		
		if ($alias_grupo=="") 
		{	
			if($this->idioma=="es")			
				$alias_grupo="grupo_companex";
			if($this->idioma=="en")
				$alias_grupo="companex_group";
				
			$grupo=true;
		}
		
		$this->view->alias_grupo=$alias_grupo;
		
		$this->view->tabla=$db->fetchAll("
				SELECT * 
				FROM estatico
				WHERE est_seccion=2 AND est_alias_$this->idioma=?
				ORDER BY est_importancia DESC,est_id DESC 
				",$alias_grupo);
				
		if($grupo)
			$this->render("index2");
			
			
			
	}	
	
}
