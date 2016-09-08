<?php
class Admin_GaleriavideosController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/galeriavideos';
		$this->data = new Model_Galeria_Galeriavideos();			
		$this->form = new Admin_Form_Galeria_Galeriavideos();

		$this->view->title = 'Videos';
		
			
		/*para subir archivos*/
		$this->file = array('vid_img');
		$this->upload = array('upload/galeria_fotos/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>550,'height'=>400));
		$this->thumb_size=array(array('width'=>200,'height'=>100));
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','');
      $sesion_adm=new Zend_Session_Namespace('unico');
              $this->tipo_user=$sesion_adm->tipo;
		/*son imagenes y se mostraran como tales*/
//		$this->view->imagenes=array();
	}
	
	
	
	public function _listar() {
				
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array('id'=>'vid_id',
				 'Posición'=>new Zend_Db_Expr("CASE vid_tipo WHEN 1 THEN 'Abajo' WHEN 2 THEN 'Costado'  WHEN 0 THEN 'Listado' ELSE 'Error' END"),
                 	   'Nombre'=>'vid_titulo_es',
                        'url'=>'vid_youtube',
                     'Imagen'=>'vid_img',
                 ))
               
                     ;
		return $select;		
	}
//	 public function listarAction() {
////             $this->view->t=2;
////              $this->view->tm=10000000;
//		$paginator = Zend_Paginator::factory($this->_listar());
//		$paginator
//			->setItemCountPerPage($this->numero_registros)
//			->setPageRange($this->rango_paginas)
//			->setCurrentPageNumber($this->_getParam('page'));
//		$this->view->data = $paginator; 
//	}
	
}