<?php
class Admin_VoluntariadobeneficiosController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/voluntariadobeneficios';
		$this->data = new Model_Contacto_Voluntariobeneficios();		
		$this->form = new Admin_Form_Contacto_Voluntariadobeneficios();		
		$this->upload  = '/admin/voluntariadotipo';
		$this->view->title = 'Voluntariado beneficios';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id',"orden","borrar");
		$this->view->orden=true;
		$this->view->no_nuevo=false;
                
		
	}
	
	
	
	public function _listar() {
		
$db = Zend_Registry::get ( 'db' );		
$select = $db->select ()
             ->from (array('c'=>$this->data->info('name')),
array('id'=>'c.ben_id',   
       'orden'=>'c.ben_orden',
       'Titulo'=>'c.ben_titulo_es',
       'Detalle'=>'c.ben_descripcion_es',
       'Estado'=>new Zend_Db_Expr("CASE c.ben_estado WHEN 1 THEN 'Activo' "
               . " WHEN 0 THEN 'Inactivo'"
               . "ELSE 'Error' END"),
      ))
->order("c.ben_orden desc")                 
;
         
		return $select;		
	}
}