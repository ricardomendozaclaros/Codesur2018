<?php
class Admin_PresentacionController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/presentacion';
		$this->data = new Model_Marca_Presentacion();			
		$this->form = new Admin_Form_Marca_Presentacion();
		$this->view->title = 'Presentaciones';
		
		
		/*dependencia*/
		$this->idp=$this->_request->getParam('idp');
		if($this->idp)
		{
			$this->modelo_padre=new Model_Marca_Marca();
			$this->mensaje="Presentaciones de: ";
			$this->nombre_padre="mar_nombre_es";			
			$this->llave_foranea="mar_id";							
		}	
		
		
		/*para subir archivos*/
		$this->file = array('pre_img','pre_etiqueta');
		$this->upload = array('upload/presentacion/','upload/presentacion/');
		$this->resize=array(true,false);
		$this->thumb=array(false,true);
		$this->img_size=array(array('width'=>200,'height'=>200),null);
		$this->thumb_size=array(null,array('width'=>600,'height'=>260));
		$this->nro_imgs=2;		
		
		/*listado*/
		$this->numero_registros=50;
		$this->rango_paginas=50;
		$this->view->hidden=array('id','orden','Posición');
		
				
		
		
		/*son imagenes y se mostraran como tales*/
		//$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=false;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		
		$this->view->orden=true;
		
		//$this->no_auto_listar='listar';
		
		
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('p'=>$this->data->info('name')),
                 array('id'=>'p.pre_id',  
                 	   'orden'=>'p.pre_orden',               		
                 	   'Nombre'=>'p.pre_nombre_es'                         	   
                 	   
                 ))     
                 ->order(array('pre_orden DESC','pre_id DESC'))                 
                 ;
        if($this->idp)
        	$select->where("p.mar_id=?",$this->idp);
                 
         
		return $select;		
	}
		
		
}