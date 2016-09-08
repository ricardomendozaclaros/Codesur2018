<?php
class Admin_VoluntariadopreguntasController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/voluntariadopreguntas';
		$this->data = new Model_Contacto_Voluntariopreguntas();		
		$this->form = new Admin_Form_Contacto_Voluntariadopreguntas();		
		$this->upload  = '/admin/voluntariadopreguntas';
		$this->view->title = 'Preguntas frecuentes de Voluntariado';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id',"orden");
		$this->view->orden=false;
		$this->view->no_nuevo=false;
                
		
	}
	
	
	
	public function _listar() {
		
$db = Zend_Registry::get ( 'db' );		
$select = $db->select ()
->from (array('c'=>$this->data->info('name')),
array('id'=>'c.pre_id',   
      // 'orden'=>'c.pre_orden',
       'Titulo'=>'c.pre_titulo_es',
       'Detalle'=>'c.pre_descripcion_es',
       'Estado'=>new Zend_Db_Expr("CASE c.pre_estado WHEN 1 THEN 'Activo' "
               . " WHEN 0 THEN 'Inactivo'"
               . "ELSE 'Error' END"),
      ))
//->order("c.pre_orden desc")                 
;
         
		return $select;		
	}
}