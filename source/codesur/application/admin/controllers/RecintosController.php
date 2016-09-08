<?php
class Admin_RecintosController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/recintos';
		$this->data = new Model_Recintos_Recintos();			
		$this->form = new Admin_Form_Recintos_Recintos();
		$this->view->title = 'Recintos';
		
		/*para subir archivos*/
		$this->file = array('rec_img');
		$this->upload = array('upload/recintos/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>700,'height'=>350));
		$this->thumb_size=array(array('width'=>175,'height'=>100));
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden','Posición');
		
				
		
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		
		$this->view->orden=true;
		
		//$this->no_auto_listar='listar';
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('r'=>$this->data->info('name')),
                 array('id'=>'r.rec_id',
                 	   'orden'=>'r.rec_orden',                 	   
                 	   'Título'=>'r.rec_titulo_es',
                           'Descripcion'=>'r.rec_descripcion_es',
                           'Direccion'=>'r.rec_direccion_es',
                      'Imagen'=>new Zend_Db_Expr("concat('/thumb/s',r.rec_img)")
                         //  'Map'=>'r.rec_google_map',
                 	   //'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(r.rec_fecha_creacion,'%d/%m/%y')")
                 ))                 
                 ->order(array('rec_orden DESC','rec_id DESC'))                 
                 ;
                 
         
		return $select;		
	}	
			
}