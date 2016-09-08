<?php
class Admin_SociosController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/socios';
		$this->data = new Model_Socios_Socios();			
		$this->form = new Admin_Form_Socios_Socios();
		$this->view->title = 'Socios Estrategicos';
		
		/*para subir archivos*/
		$this->file = array('soc_img');
		$this->upload = array('upload/socios/');
		$this->resize=array(true);
		$this->thumb=array(false);
		$this->img_size=array(array('width'=>160,'height'=>80));
		$this->thumb_size=array(null);
		$this->nro_imgs=1;
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;		
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		
		$this->view->orden=true;
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('s'=>$this->data->info('name')),
                 array('id'=>'s.soc_id',
                 		'orden'=>'s.soc_orden',
                 	   'Nombre'=>'s.soc_titulo_es',
                 	   'Imagen'=>'s.soc_img'                 	   
                 	   //'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(b.ban_fecha_creacion,'%d/%m/%y')")
                 ))
                 ->order(array('soc_orden DESC','soc_id DESC','soc_fecha_creacion DESC'))                                 
                 ;                 
         
		return $select;		
	}	
	
		
}