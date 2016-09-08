<?php
class Admin_DeportesController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/deportes';
		$this->data = new Model_Deportes_Deportes();			
		$this->form = new Admin_Form_Deportes_Deportes();

		$this->view->title = 'Deportes';
		
			
		/*para subir archivos*/
		$this->file = array('dep_img1','dep_img2');
		$this->upload = array('upload/deportes/','upload/deportes/');
		$this->resize=array(true,true);
		$this->thumb=array(true,true);
		$this->img_size=  array(array('width'=>900,'height'=>300),array('width'=>169,'height'=>160));
		$this->thumb_size=array(array('width'=>169,'height'=>160),array('width'=>169,'height'=>169));
		$this->nro_imgs=2;		
		
		/*listado*/
		$this->numero_registros=90;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','');
//        $sesion_adm=new Zend_Session_Namespace('unico');
//              $this->tipo_user=$sesion_adm->tipo;
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array("Imagen","Imagen2");
                	$this->view->edit_img=true;
	}
	
	
	public function _listar() {
				
		$db = Zend_Registry::get ( 'db' );
        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array('id'=>'dep_id',
                 	   'Nombre'=>'dep_titulo_es',
                           'Detalle'=>'dep_detalle_es',
                         'Imagen2'=>new Zend_Db_Expr("concat('/thumb/s',dep_img2)") ,
                       'Imagen'=>new Zend_Db_Expr("concat('/thumb/s',dep_img1)")
                 ))
                  ;
//                $this->view->sec_titulo=$ss_titulo;
		return $select;		
	}
//	 public function listarAction() {
//
//		$paginator = Zend_Paginator::factory($this->_listar());
//		$paginator
//			->setItemCountPerPage($this->numero_registros)
//			->setPageRange($this->rango_paginas)
//			->setCurrentPageNumber($this->_getParam('page'));
//		$this->view->data = $paginator; 
//	}
	
}