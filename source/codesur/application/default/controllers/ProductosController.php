<?php
class ProductosController extends Zend_Controller_Action
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
		$this->view->headTitle($this->view->translate("Productos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Productos"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Productos"),'keywords');
		
		
		$this->numero_registros=4;
		$this->rango_paginas=10;
		
		$this->_helper->layout()->setLayout("layout_bo");
		
		
	}	
	
	public function indexAction()
	{ 	
		
		$categoria=$this->_request->getParam('categoria');
		$sub_categoria=$this->_request->getParam('sub_categoria');
		
		$this->view->categoria=$categoria;
		$this->view->sub_categoria=$sub_categoria;
		
		$db=Zend_Registry::get('db');
		$this->view->tabla=$db->fetchAll("
				SELECT p.pro_nombre_$this->idioma as pro_nombre,p.pro_alias_$this->idioma as pro_alias,s.sub_alias_$this->idioma as sub_alias,s.sub_nombre_$this->idioma as sub_nombre,m.mar_alias_$this->idioma as mar_alias,m.mar_nombre_$this->idioma as mar_nombre,m.* 
				FROM marca m
				JOIN sub_producto s ON s.sub_id=m.sub_id
				JOIN producto p ON p.pro_id=m.pro_id
				WHERE s.sub_alias_$this->idioma=? 
				ORDER BY m.mar_orden DESC, m.mar_id DESC				
				",$sub_categoria);
	}
	
		
	public function presentacionAction()
	{ 			
		$categoria=$this->_request->getParam('categoria');
		$sub_categoria=$this->_request->getParam('sub_categoria');
		$presentacion=$this->_request->getParam('presentacion');
		
		$this->view->categoria=$categoria;
		$this->view->sub_categoria=$sub_categoria;
		
		$db=Zend_Registry::get('db');
		$this->view->fila=$db->fetchRow("
				SELECT p.*,pro.pro_nombre_$this->idioma as pro_nombre,pro.pro_alias_$this->idioma as pro_alias,m.mar_nombre_$this->idioma as mar_nombre,m.mar_alias_$this->idioma as mar_alias 
				FROM presentacion p
				JOIN marca m ON p.mar_id=m.mar_id
				JOIN producto pro ON pro.pro_id=m.pro_id
				WHERE p.pre_alias_$this->idioma=?				
				",$presentacion);
				
	}
	public function categoriaAction(){
		
		$categoria=$this->_request->getParam('categoria');		
		
		
		$db=Zend_Registry::get('db');

			$fila=$db->fetchRow("
					SELECT p.pro_alias_$this->idioma as pro_alias,m.mar_alias_$this->idioma as mar_alias 
					FROM marca m				
					JOIN producto p ON p.pro_id=m.pro_id
					WHERE p.pro_alias_$this->idioma=? 
					ORDER BY m.mar_orden DESC
					LIMIT 1				
					",$categoria);
			if($fila){		
						
			$enlace=$this->view->url(array("idioma"=>$this->idioma,"categoria"=>$fila["pro_alias"],"marca"=>$fila["mar_alias"]),"marca_".$this->idioma);

			$this->_redirect($enlace);	
			}	
			else
			{
				$this->view->categoria=$categoria;	
				$this->view->tabla=array();	
			}	
	}
	
	public function marcaAction(){
		
		$categoria=$this->_request->getParam('categoria');
		$marca=$this->_request->getParam('marca');
		
		
		$db=Zend_Registry::get('db');

		
			$fila=$db->fetchRow("
					SELECT p.pro_nombre_$this->idioma as pro_nombre,p.pro_alias_$this->idioma as pro_alias,m.mar_alias_$this->idioma as mar_alias,m.mar_nombre_$this->idioma as mar_nombre,m.* 
					FROM marca m				
					JOIN producto p ON p.pro_id=m.pro_id
					WHERE m.mar_alias_$this->idioma=?
					",$marca);			
						
						
		$id_marca=$fila['mar_id'];		
			
		$this->view->tabla=$db->fetchAll("
				SELECT p.pre_nombre_$this->idioma as pre_nombre,p.pre_alias_$this->idioma as pre_alias,p.* 
				FROM presentacion p				
				JOIN marca m ON m.mar_id=p.mar_id
				WHERE p.mar_id=? 
				ORDER BY p.pre_orden DESC				
				",$id_marca);		
		
		$this->view->fila=$fila;
		$this->view->categoria=$categoria;	
		$this->view->marca=$marca;
		
		
		
		
		
	}
	
}
