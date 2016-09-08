<?php
class Admin_ConvocatoriasController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/convocatorias';
		$this->data = new Model_Convocatorias_Convocatorias();			
		$this->form = new Admin_Form_Convocatorias_Convocatorias();

		$this->view->title = 'Convocatorias';
		
			
		/*para subir archivos*/
		$this->file = array('con_pdf');
		$this->upload = array('upload/convocatoria/');
		$this->resize=array(false);
		$this->thumb=array(false);
		$this->img_size=array(array('width'=>200,'height'=>100));
		$this->thumb_size=array(array('width'=>200,'height'=>100));
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','');
//        $sesion_adm=new Zend_Session_Namespace('unico');
//              $this->tipo_user=$sesion_adm->tipo;
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array("Imagen");
	}
	
	
	
	public function _listar() {
				
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array('id'=>'con_id',
                 	   'Nombre'=>'con_titulo_es',
                         //  'url'=>'vid_youtube',
                     'Pdf'=>'con_pdf',
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