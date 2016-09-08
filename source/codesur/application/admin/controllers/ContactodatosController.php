<?php
class Admin_ContactodatosController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/contactodatos';
		$this->data = new Model_Contacto_Datos();		
		$this->form = new Admin_Form_Contacto_Datos();		
		
		$this->view->title = 'Contacto Datos';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id','borrar','marcar');
		
		$this->view->no_nuevo=true;
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('c'=>$this->data->info('name')),
                 array('id'=>'con_id',        
                 	   'Titulo'=>'con_titulo_es'
                 ))
                 ->order("con_id desc")
                 ->limit(1,0)                 
                 ;
         
		return $select;		
	}
}