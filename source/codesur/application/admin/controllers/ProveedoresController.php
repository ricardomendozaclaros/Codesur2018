<?php
class Admin_ProveedoresController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/proveedores';
		$this->data = new Model_Proveedores_Proveedores();			
		$this->form = new Admin_Form_Proveedores_Proveedores();
		$this->view->title = 'Proveedores';
		
		/*para subir archivos*/
		$this->file = array('pro_img');
		$this->upload = array('upload/proveedores/');
		$this->resize=array(false);
		$this->thumb=array(false);
		$this->img_size=array(array('width'=>148,'height'=>103));
		$this->thumb_size=array(null);
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		
				
		
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		
		$this->view->orden=true;
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('p'=>$this->data->info('name')),
                 array('id'=>'p.pro_id',
                 		'orden'=>'p.pro_orden',
                 	   'Nombre'=>'p.pro_nombre_es',
                 	   'Imagen'=>'p.pro_img'                 	   
                 	   //'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(b.ban_fecha_creacion,'%d/%m/%y')")
                 ))
                 ->order(array('pro_orden DESC','pro_id DESC','pro_fecha_creacion DESC'))                 
                 ;
                 
         
		return $select;		
	}	
	
		
}