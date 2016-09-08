<?php
class Admin_OrganizacionController extends Z_Admin_Controller {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/organizacion';
		$this->data = new Model_Organizacion_Organizacion();			
		$this->form = new Admin_Form_Organizacion_Organizacion();
		$this->view->title = 'Organizacion';
		
		/*para subir archivos*/
//		$this->file = array('org_img');
		$this->upload = array('/upload/certificaciones/');
//		$this->resize=array(true);
//		$this->thumb=array(false);
//		$this->img_size=array(array('width'=>142,'height'=>104));
//		$this->thumb_size=array(null);
//		$this->nro_imgs=1;
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		
		
		/*son imagenes y se mostraran como tales*/
//		$this->view->imagenes=array('Imagen');
		
//		$this->view->edit_img=true;		
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		
		$this->view->orden=true;
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('c'=>$this->data->info('name')),
                 array('id'=>'c.org_id',
                 	   'orden'=>'c.org_orden',
//                 	   'Nombre'=>'c.org_titulo_es',
                 	   'Descripcion'=>'c.org_descripcion_es'                 	   
                 	   //'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(b.ban_fecha_creacion,'%d/%m/%y')")
                 ))
                 ->order(array('org_orden asc','org_id DESC'))                                 
                 ;                 
         
		return $select;		
	}	
	
		
}