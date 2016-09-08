<?php
class Admin_MarcaController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/marca';
		$this->data = new Model_Marca_Marca();			
		$this->form = new Admin_Form_Marca_Marca();
		$this->view->title = 'Marcas';
		
		/*para subir archivos*/
		$this->file = array('mar_img');
		$this->upload = array('upload/marca/');
		$this->resize=array(true);
		$this->thumb=array(false);
		$this->img_size=array(array('width'=>160,'height'=>160));
		$this->thumb_size=array(null);
		$this->nro_imgs=1;		
		
		
		/*padre de dependiente*/
		$this->dependiente="presentacion";
		$this->dependiente_file=array("pre_img","pre_etiqueta");
		$this->dependiente_ruta="upload/presentacion/";
		
		/*listado*/
		$this->numero_registros=50;
		$this->rango_paginas=50;
		$this->view->hidden=array('id','orden','Posición');
		
				
		$this->view->link=array('Presentaciones'=>array('url'=>'/admin/presentacion/listar/','alt'=>'Ver Presentaciones'));
		
		/*son imagenes y se mostraran como tales*/
		//$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
		
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
                 array('id'=>'m.mar_id',  
                 	   'orden'=>'m.mar_orden',               		
                 	   'Nombre'=>'m.mar_nombre_es',
                 	   'Presentaciones'=>new Zend_Db_Expr("'Ver/Editar/Agregar Presentaciones'"),
                 	   'Producto'=>'p.pro_nombre_es'                    	   
                 	   
                 ))   
                 ->join(array("p"=>"producto"),"p.pro_id=m.pro_id",array())              
                 //->order(array('pro_nombre_es','mar_orden DESC','mar_id DESC'))                 
                 ->order(array('mar_orden DESC','mar_id DESC'))
                 ;
                 
         
		return $select;		
	}	
	
	
	
	

	
		
		
}