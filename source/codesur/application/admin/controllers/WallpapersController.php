<?php
class Admin_WallpapersController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/wallpapers';
		$this->data = new Model_Wallpapers_Wallpapers();	
		$this->form = new Admin_Form_Wallpapers_Fotos();
		
		$this->view->title = 'Wallpapers';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id',"orden","borrar");
		$this->view->orden=true;
		$this->view->no_nuevo=false;
                
                $this->file = array('wal_img');
		$this->upload  = '/admin/wallpapers';
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>1366,'height'=>768));
		$this->thumb_size=array(array('width'=>200,'height'=>200));
		$this->nro_imgs=1;
                
		
	}
	
	
	
	public function _listar() {
		
$db = Zend_Registry::get ( 'db' );		
$select = $db->select ()
->from (array('c'=>"wallpaper"),
array('id'=>'c.wal_id',   
       'Titulo'=>'c.wal_titulo_es',
       'Imagen'=>new Zend_Db_Expr("concat('/thumb/',c.wal_img"),
       'Estado'=>new Zend_Db_Expr("CASE c.wal_estado WHEN 1 THEN 'Activo' "
               . " WHEN 0 THEN 'Inactivo'"
               . "ELSE 'Error' END"),
      ))
->order("c.vol_orden desc")                 
;
         
		return $select;		
	}
}