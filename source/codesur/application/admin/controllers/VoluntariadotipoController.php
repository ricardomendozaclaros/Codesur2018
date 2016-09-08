<?php
class Admin_VoluntariadotipoController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/voluntariadotipo';
		$this->data = new Model_Contacto_Voluntariotipo();		
		$this->form = new Admin_Form_Contacto_Voluntariadotipo();		
		$this->upload  = '/admin/voluntariadotipo';
		$this->view->title = 'Tipos de Voluntariado';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id',"orden","borrar");
		$this->view->orden=true;
		$this->view->no_nuevo=false;
                
		
	}
	
	
	
	public function _listar() {
		
$db = Zend_Registry::get ( 'db' );		
$select = $db->select ()
->from (array('c'=>"vountariado_tipo"),
array('id'=>'c.vol_id',   
       'orden'=>'c.vol_orden',
       'Titulo'=>'c.vol_titulo_es',
       'Detalle'=>'c.vol_descripcion_es',
       'Estado'=>new Zend_Db_Expr("CASE c.vol_estado WHEN 1 THEN 'Activo' "
               . " WHEN 0 THEN 'Inactivo'"
               . "ELSE 'Error' END"),
      ))
->order("c.vol_orden desc")                 
;
         
		return $select;		
	}
}