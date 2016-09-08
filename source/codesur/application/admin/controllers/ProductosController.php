<?php
class Admin_ProductosController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/productos';
		$this->data = new Model_Categorias_Productos();		
		$this->form = new Admin_Form_Categorias_Productos();		
					
		$this->view->title = 'Productos';
		$this->numero_registros=50;
		$this->rango_paginas=20;		
		
		$this->view->hidden=array('id');
		
		//$this->view->orden=true;
	
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('p'=>$this->data->info('name')),
                 array('id'=>'pro_id',                 	                    	   
                 	   'Nombre'=>'pro_nombre_es',
                 		'Importancia'=>'pro_importancia'
                 ))
                 
                 ->order(array("pro_importancia desc","pro_id DESC"))
                 ;
         
		return $select;		
	}
}