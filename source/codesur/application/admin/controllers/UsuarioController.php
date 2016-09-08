<?php
class Admin_UsuarioController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/Usuario';
		$this->data = new Model_Usuario_Usuario();		
		$this->form = new Admin_Form_Usuario_Usuario();
		
		$this->view->title = 'Usuarios';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id');

		$this->view->no_guardar=true;
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get('db');		
        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array(	'id'=>'usu_id',
                 	   	'Nombre'=>'usu_nombre',                 	   
                 		'Apellido'=>'usu_apellido',
                 		'Email'=>'usu_email',                 		
                 		'Fecha Alta'=>new Zend_Db_Expr("DATE_FORMAT(usu_fecha_creacion,'%d/%m/%y')")	   	
                 ))     
                 ->order(array("usu_fecha_creacion DESC","usu_id DESC"))
                 ;
         
		return $select;		
	}	
}