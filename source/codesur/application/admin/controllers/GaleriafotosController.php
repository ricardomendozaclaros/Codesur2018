<?php
class Admin_GaleriafotosController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/galeriafotos';
		$this->data = new Model_Galeria_Fotos();			
		$this->form = new Admin_Form_Galeria_Fotos();

		$this->view->title = 'Fotos';
		
			
		/*para subir archivos*/
		$this->file = array('fot_img');
		$this->upload = array('upload/galeria_fotos/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>500,'height'=>300));
		$this->thumb_size=array(array('width'=>250,'height'=>150));
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
                $sesion_sec=new Zend_Session_Namespace('secciones');
                
    if($this->_request->getParam('seccion')){
            $ss=$this->_request->getParam('seccion');
            $seccc='select * from fotos_seccion where sec_estado=1 and sec_id='.$ss;
            $seccc=$db->fetchRow($seccc);
            $ss_titulo=$seccc['sec_nombre_es'];
            $sesion_sec->tipo=$ss;
            $sesion_sec->tiutlo=$seccc['sec_nombre_es'];
        }else{
               if($sesion_sec->tipo){
                    $ss=$sesion_sec->tipo;
                    $ss_titulo=$sesion_sec->tiutlo;
                }else{
                            $sec='select * from fotos_seccion where sec_estado=1';
                            $sec=$db->fetchRow($sec);
                           $ss=$sec["sec_id"]; 
                           $ss_titulo=$sec['sec_nombre_es'];
                           $sesion_sec->tipo=$ss;
                           $sesion_sec->tiutlo=$sec['sec_nombre_es'];
                        } 
                }
        $select = $db->select ()
                 ->from ($this->data->info('name'),
                 array('id'=>'fot_id',
                 	   'Nombre'=>'fot_titulo_es',
                         //  'url'=>'vid_youtube',
                     'Imagen'=>'fot_img',
                 ))
                ->where("sec_id=$ss")
               
                     ;
                $this->view->sec_titulo=$ss_titulo;
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