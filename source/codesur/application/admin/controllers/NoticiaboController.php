<?php
class Admin_NoticiaboController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/noticiabo';
		$this->data = new Model_Noticia_Noticia();			
		$this->form = new Admin_Form_Noticia_Noticia();
		$this->view->title = 'Noticias Bolivia';
		
		/*para subir archivos*/
		$this->file = array('not_img');
		$this->upload = array('upload/noticia/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>360));
		$this->thumb_size=array(array('width'=>164,'height'=>114));
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden','Posición');
		
				
		
		
		/*son imagenes y se mostraran como tales*/
		//$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posición';
		
		$this->view->orden=true;
		
		//$this->no_auto_listar='listar';
		
		$this->form->not_pos->setValue("2");
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('n'=>$this->data->info('name')),
                 array('id'=>'n.not_id',
                 		'orden'=>'n.not_orden',
                 	   'Posición'=>new Zend_Db_Expr("CASE not_pos WHEN 1 THEN 'Principal' WHEN 2 THEN 'Secundaria' ELSE 'Error' END"),
                 	   'Título'=>'n.not_titulo_es',                              	   
                 	   'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(n.not_fecha_creacion,'%d/%m/%y')")
                 ))
                 ->where("not_pos=2")
                 ->order(array('not_pos','not_orden DESC','not_id DESC','not_fecha_creacion DESC'))                 
                 ;
                 
         
		return $select;		
	}
	
	public function indexAction() {
		
		
		$idc=(int)$this->_request->getParam('idc');
		if($idc)
		{
			$this->form->getElement($this->view->prefijo_categoria.'id')->setValue($idc);
		}
		
		$orden=$this->view->Form->getElement($this->data->prefijo."orden");
		if($orden)
		{			
			$orden->setValue($this->obtener_orden()+1);			
		}
		$sesion_agregar=new Zend_Session_Namespace('agregar');
		$sesion_agregar->id=rand(0,9999);
		
		
		$this->view->pre_title="Agregar";
		if($this->no_auto_agregar)
			$this->render($this->no_auto_agregar);
		else		
			$this->render('z/files', null, true);
	}
	
	function obtener_orden()
	{
		$fila=$this->data->fetchRow("not_pos=2",$this->data->prefijo."orden DESC");
		if($fila)$fila->toArray();
		$n_orden=(int)$fila[$this->data->prefijo."orden"];
		return $n_orden;
	}	
	
	public function posicionAction()
	{
		$id=$this->_request->getParam('id');
		$tipo=$this->_request->getParam('tipo');
	
		if($tipo=="subir")
			$this->subirPosicion($id);
		elseif ($tipo=="bajar") 
			$this->bajarPosicion($id);
		
		$this->_redirect($_SERVER['HTTP_REFERER']);
	}
	
	
	private function subirPosicion($id)
	{
		//$fila=$this->data->fetchRow('edi_id='.$this->edicion_actual." and not_id","$this->sufijo")->toArray();
		$fila=$this->data->fetchRow($this->data->prefijo."id=".$id)->toArray();
		
		$posicion="not_pos";
			
		$pos=(int)$fila[$posicion];
		if($pos>1)
			$this->data->edit(array($this->data->prefijo."id"=>$id,$posicion=>($pos-1)));
	}
	
	private function bajarPosicion($id)
	{
		//$fila=$this->data->fetchRow('edi_id='.$this->edicion_actual." and not_id","$this->sufijo")->toArray();
		$fila=$this->data->fetchRow($this->data->prefijo."id=".$id)->toArray();
	
		$posicion="not_pos";
		$max=2;
		
		$pos=(int)$fila[$posicion];
		if($pos<$max)
			$this->data->edit(array($this->data->prefijo."id"=>$id,$posicion=>($pos+1)));
		
		
	}
	
		
}