<?php
class Admin_RotadorController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/rotador';
		$this->data = new Model_Rotador_Rotador();
		$this->form = new Admin_Form_Rotador_Img();
		$this->view->title = 'Rotador';
		
		/*para subir archivos*/
		$this->file = array('rot_img');
		$this->upload = array('upload/rotador/');
		$this->resize=array(true);
		$this->thumb=array(false);
		$this->img_size=array(array('width'=>890,'height'=>540));
		$this->thumb_size=array(null);
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
		$this->view->orden=true;
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		$this->view->orden=true;
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
                $select = $db->select ()
                 ->from (array('r'=>$this->data->info('name')),
                 array('id'=>'r.rot_id',
                 'orden'=>'r.rot_orden',
                 	   'Nombre'=>'r.rot_nombre_es',
                 	   'Imagen'=>'r.rot_img',
                 	 'Mostrar'=>new Zend_Db_Expr("CASE rot_estado WHEN 1 THEN 'Si' WHEN 0 THEN 'No' ELSE 'Error' END"),
                 ))                 
                 ->order(array("r.rot_id DESC"))                 
                 ;                
         
		return $select;		
	}	

		
}