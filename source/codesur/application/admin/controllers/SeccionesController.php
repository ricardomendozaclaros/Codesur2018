<?php
class Admin_SeccionesController extends Z_Admin_Controller {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/secciones';
		$this->data = new Model_Galeria_Secciones();			
		$this->form = new Admin_Form_Galeria_Secciones();
		$this->view->title = 'Seccion';
		
		/*para subir archivos*/
//		$this->file = array('sec_img');
		$this->upload = array('upload/marca/');
//		$this->resize=array(true);
//		$this->thumb=array(false);
//		$this->img_size=array(array('width'=>160,'height'=>160));
//		$this->thumb_size=array(null);
//		$this->nro_imgs=1;		
		
		
		/*padre de dependiente*/
//		$this->dependiente="presentacion";
//		$this->dependiente_file=array("pre_img","pre_etiqueta");
//		$this->dependiente_ruta="upload/presentacion/";
		
		/*listado*/
		$this->numero_registros=50;
		$this->rango_paginas=50;
		$this->view->hidden=array('id','orden','Posición');
		
				
//		$this->view->link=array('Presentaciones'=>array('url'=>'/admin/presentacion/listar/','alt'=>'Ver Presentaciones'));
		
		/*son imagenes y se mostraran como tales*/
		//$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=false;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Producto';
		
		$this->view->orden=true;
		
		//$this->no_auto_listar='listar';
		
		
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('m'=>$this->data->info('name')),
                      array('id'=>'m.sec_id',  
                 	   //'orden'=>'m.sec_orden',               		
                 	   'Nombre'=>'m.sec_nombre_es',
                          'Nombre (En)'=>'m.sec_nombre_en',
                 	 //  'Presentaciones'=>new Zend_Db_Expr("'Ver/Editar/Agregar Presentaciones'"),
                 	  // 'Producto'=>'p.pro_nombre_es'                    	   
                 	   
                 ))   
              //   ->join(array("p"=>"producto"),"p.pro_id=m.pro_id",array())              
                 //->order(array('pro_nombre_es','sec_orden DESC','sec_id DESC'))                 
                 ->order(array('sec_id DESC'))
                 ;
                 
         
		return $select;		
	}	
	
	
	
	

	
		
		
}