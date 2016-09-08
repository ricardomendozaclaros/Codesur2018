<?php
class Admin_EstaticoController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/estatico';
		$this->data = new Model_Estatico_Estatico();		
		$this->form = new Admin_Form_Estatico_Estatico();

		
		$this->view->title = 'Contenido Estático';
		$this->numero_registros=50;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id',"borrar","marcar");
		$this->view->no_nuevo=true;
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('e'=>$this->data->info('name')),
                 array('id'=>'est_id',
                 	   'Nombre'=>'est_nombre_es'
                 ))                 
                 ->order(array("est_id"))                 
                 
                 ;
         
		return $select;		
	}
}