<?php
class Admin_LinkController extends Z_Admin_Controller{

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/link';
		$this->data = new Model_Link_Link();			
		$this->form = new Admin_Form_Link_Link();
		$this->view->title = 'Link Sugeridos';
		
		/*para subir archivos*/
		/*$this->file = array('rec_img');*/
		$this->upload = array('upload/link/');
		/*$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>700,'height'=>350));
		$this->thumb_size=array(array('width'=>175,'height'=>100));
		$this->nro_imgs=1;*/		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden','Posici¨®n');

		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array(false);
		
		$this->view->edit_img=false;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posici¨®n';
		
		$this->view->orden=true;
		
		//$this->no_auto_listar='listar';
		
	}
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('r'=>$this->data->info('name')),
                 array('id'=>'r.lin_id',
                 	   'orden'=>'r.lin_orden',                 	   
                 	   'Titulo'=>'r.lin_titulo_es',
                           'Direccion url'=>'r.lin_link',
		           'Estado'=>new Zend_Db_Expr("CASE lin_estado WHEN 1 THEN 'Activo' WHEN 2 THEN 'Inactivo' ELSE 'Error' END"),
                          //'Imagen'=>new Zend_Db_Expr("concat('/thumb/s',r.rec_img)")
                          //'Map'=>'r.rec_google_map',
                 	  //'Fecha Creaci¨®n'=>new Zend_Db_Expr("DATE_FORMAT(r.rec_fecha_creacion,'%d/%m/%y')")
                 ))                 
                 ->order(array('lin_orden DESC','lin_id DESC'))                 
                 ;
                 
         
		return $select;		
	}	
			
}