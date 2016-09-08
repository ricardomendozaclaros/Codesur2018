<?php
class Admin_PaisesController extends Z_Admin_ControllerFile {

	public function _init() {

		$this->url  = '/admin/paises';
		$this->data = new Model_Pais_Pais();		
		$this->form = new Admin_Form_Paises_Paises();		
					

	
		/*para subir archivos*/
		$this->file = array('pai_img');
		$this->upload = array('upload/paises/');
		$this->resize=array(true);
		$this->thumb=array(false);
		$this->img_size=array(array('width'=>150,'height'=>103));
		$this->thumb_size=array(null);
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
		
//		$this->view->file=array('pai_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		$this->view->orden=true;
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
                $select = $db->select ()
                 ->from (array('r'=>$this->data->info('name')),
                 array('id'=>'r.pai_id',
                 //'orden'=>'r.rot_orden',
                 	   'Nombre'=>'r.pai_titulo_es',
                     'Imagen'=>'r.pai_img',
                 	   //'Imagen'=>new Zend_Db_Expr("concat('/upload/paises/',r.pai_img)"),
                       'Descripcion'=>'r.pai_detalle_es',
                 	  // 'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(r.rot_fecha_creacion,'%d/%m/%y')")
                 ))                 
                 ->order(array("r.pai_id DESC"))                 
                 ;                
         
		return $select;		
	}	

		
}