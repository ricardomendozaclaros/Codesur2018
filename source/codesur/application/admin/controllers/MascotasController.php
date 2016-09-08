<?php
class Admin_MascotasController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/mascotas';
		$this->data = new Model_Mascotas_Mascotas();			
		$this->form = new Admin_Form_Mascotas_Mascotas();

		$this->view->title = 'Mascotas';
		
			
		/*para subir archivos*/
		$this->file = array('mas_img');
		$this->upload = array('upload/mascotas/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>500,'height'=>300));
		$this->thumb_size=array(array('width'=>250,'height'=>150));
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=4;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','');
		$this->view->imagenes=array("Imagen");
	}
	
	
	
	public function _listar() {
				
	$db = Zend_Registry::get ( 'db' );

        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array('id'=>'mas_id',
                 	   'Nombre'=>'mas_nombre_es',
                           'Detalle'=>'mas_detalle_es',
                           'Imagen'=>'mas_img',
                 ))
                     ;
//                $this->view->sec_titulo=$ss_titulo;
		return $select;		
	}
	 public function listarAction() {

		$paginator = Zend_Paginator::factory($this->_listar());
		$paginator
			->setItemCountPerPage($this->numero_registros)
			->setPageRange($this->rango_paginas)
			->setCurrentPageNumber($this->_getParam('page'));
		$this->view->data = $paginator; 
	}
	
}