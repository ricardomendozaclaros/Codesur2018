<?php
class Admin_HistoriaController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/historia';
		$this->data = new Model_Historia_Historia();
		$this->form = new Admin_Form_Historia_Historia();
		$this->view->title = 'Historia';
		
		/*para subir archivos*/
		$this->file = array('his_img1','his_img2');
		$this->upload = array('upload/historia/','upload/historia/');
		$this->resize=array(true,true);
		$this->thumb=array(true,true);
		$this->img_size=array(array('width'=>700,'height'=>300),array('width'=>800,'height'=>500));
		$this->thumb_size=array(array('width'=>150,'height'=>100),array('width'=>150,'height'=>100));
		$this->nro_imgs=2;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen','Imagen2');
		
		$this->view->edit_img=true;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		$this->view->orden=true;
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
                $select = $db->select ()
                 ->from (array('r'=>$this->data->info('name')),
                 array('id'=>'r.his_id',
                 //'orden'=>'r.his_orden',
                 	   'Nombre'=>'r.his_titulo_original_es',
                 	   'Imagen'=>'r.his_img1',
                           'Imagen'=>    new Zend_Db_Expr("concat('thumb/s',r.his_img1)"),
                           'Imagen2'=> new Zend_Db_Expr("concat('thumb/s',r.his_img2)"),
                           'Descrpcion'=>'r.his_descripcion_es',
//                 	   'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(r.his_fecha_creacion,'%d/%m/%y')")
                 ))                 
                 ->order(array("r.his_id DESC"))                 
                 ;                
         
		return $select;		
	}	

		
}