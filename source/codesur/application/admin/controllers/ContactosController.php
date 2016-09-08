<?php
class Admin_ContactosController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/contactos';
		$this->data = new Model_Contacto_Contacto();		
		$this->form = new Admin_Form_Contacto_Contacto();		
		$this->upload  = '/admin/contactos';
		$this->view->title = 'Contactos';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id');
		
		$this->view->no_nuevo=true;
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('c'=>$this->data->info('name')),
                 array('id'=>'con_id',   
                          'Idioma'=>new Zend_Db_Expr("CASE con_idioma WHEN en THEN 'En' WHEN es THEN 'Es' ELSE 'Error' END"),
                 	   'Nombre'=>'con_nombre',
                           'Apellidos'=>'con_paterno',
                 	   'Email Contacto'=>'con_email',         	   
                 	   'Tema'=>'con_asunto',
                 	   'Fecha'=>'con_fecha_creacion'
                 ))
                 ->order("con_fecha_creacion desc")                 
                 ;
         
		return $select;		
	}
}