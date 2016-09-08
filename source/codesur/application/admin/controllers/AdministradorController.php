<?php
class Admin_AdministradorController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/Administrador';
		$this->data = new Admin_Model_Administrador_Administrador();		
		$this->form = new Admin_Form_Administrador_Usuario();
		
		$this->view->title = 'Administradores';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id');

		$this->view->no_guardar=true;
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get('db');		
        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array(	'id'=>'id_administrador',
                 	   	//'Nombre'=>'usu_nombre',                 	   
                 		'Login'=>'login',
                 		//'Email'=>'usu_email',
                 		'Tipo'=>new Zend_Db_Expr("CASE rol 
                 								WHEN 'administrador' THEN 'Administrador'
                 								ELSE 'Invitado' 
                 								END"),
                 		//'estado'=>'usu_estado',
                 	   	//'Fecha Alta'=>'usu_fecha_edicion'
                 		//'Fecha Alta'=>new Zend_Db_Expr("DATE_FORMAT(usu_fecha_edicion,'%d/%m/%y')")	   	
                 ))     
                 ;
         
		return $select;		
	}	
}