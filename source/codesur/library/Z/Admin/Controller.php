<?php
class Z_Admin_Controller extends Zend_Controller_Action {

	public function init() {

		$this->_init();
		
		if(isset($this->idp))
		{			
			$fila=$this->modelo_padre->find($this->idp)->current()->toArray();			
			$this->view->mensaje=$this->mensaje.$fila[$this->nombre_padre];			
			$this->form->getElement($this->llave_foranea)->setValue($this->idp);			
			$this->form->idp->setValue($this->idp);
			$this->view->idp=$this->idp;
			$sesion_atras=new Zend_Session_Namespace('atras');
			if(!isset($sesion_atras->volver[$this->idp]))
			{
				unset($sesion_atras->volver);
				$sesion_atras->volver[$this->idp]=$_SERVER['HTTP_REFERER'];
			}			
			$this->view->volver=$sesion_atras->volver[$this->idp];						
		}
		else
		{			
			$sesion_atras=new Zend_Session_Namespace('atras');
			unset($sesion_atras->volver);	
		}
		
		$this->id	= $this->data->info('primary');
		$this->id	= $this->id[1];
		$this->view->id=$this->id;
		$this->view->primary_key=$this->id;
		$this->view->prefijo=$this->data->prefijo;
		$this->view->tabla=$this->data->info('name');

		$this->act  = $this->url;
		

		$this->view->Form = $this->form;
		$this->view->Form->setAction($this->act.'/agregar');

	
		$this->view->url = $this->url;
		$this->view->upload = $this->upload;
		$this->view->size =2000000;
		$this->view->ext ='*.jpg;*.png;*.gif;*.jpeg';
		$this->view->filedesc ='*.jpg,*.png,*.gif';
		
		$this->prefijo_imagen="s";
	}

	
	public function ordenAction()
	{
		$id=$this->_request->getParam('id');
		$tipo=$this->_request->getParam('tipo');
		if($tipo=="subir")
			$this->subirNivel($id);
		elseif ($tipo=="bajar") 
			$this->bajarNivel($id);
		
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');
	}
	
	private function subirNivel($id)
	{
		//$fila=$this->data->fetchRow('edi_id='.$this->edicion_actual." and not_id","$this->prefijo")->toArray();
		$fila=$this->data->fetchRow($this->data->prefijo."id=".$id)->toArray();
		$orden=(int)$fila[$this->data->prefijo."orden"];
		if($orden<1)
			$this->data->edit(array($this->data->prefijo."id"=>$id,$this->data->prefijo."orden"=>($orden-1)));
	}
	
	private function bajarNivel($id)
	{
		//$fila=$this->data->fetchRow('edi_id='.$this->edicion_actual." and not_id","$this->prefijo")->toArray();
		$fila=$this->data->fetchRow($this->data->prefijo."id=".$id)->toArray();
		$orden=(int)$fila[$this->data->prefijo."orden"];
		//if($orden!=1)
		$this->data->edit(array($this->data->prefijo."id"=>$id,$this->data->prefijo."orden"=>($orden+1)));
		
		
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
			$fila=$this->data->fetchRow(null,$this->data->prefijo."orden DESC");
			if($fila)$fila->toArray();
			$n_orden=(int)$fila[$this->data->prefijo."orden"];
			$orden->setValue($n_orden+1);			
		}
		$this->view->pre_title="Agregar";
		if(isset($this->no_auto_agregar))
			$this->render($this->no_auto_agregar);			
		else 
		{	
			if(isset($this->ajaxfile)) 
				$this->render('z/ajaxfile', null, true);	
			else
				$this->render('z/nofile', null, true);
		}
	}	

	public function agregarAction() {
		
		$request = $this->_request;		
		if ($request->isPost()) {
			$form = $this->form;
			if ($form->isValid($request->getPost())) 
			{
				$datos=$form->getValues();
				if(count($this->convertir_fecha))
				{
					foreach ($this->convertir_fecha as $elemento)
						$datos[$elemento]=Util_Date::normal_to_mysql($form->getElement($elemento)->getValue());										
				}
				
				$id = $this->data->add($datos);
				
				if ($form->idp)//si es un listado dependiente
					$this->_redirect($this->url.'/listar/idp/'.$form->idp->getValue());
				else
					$this->_redirect($this->url.'/listar');
				
			} else
				$form->populate($request->getPost());
		}
		
		$this->view->pre_title="Agregar";
		
		
		
		if($this->no_auto_agregar)
			$this->render($this->no_auto_agregar);			
		else
			$this->render('z/nofile', null, true);
		
	}

	public function listarAction() {
		
		//$this->render('z/index2', null, true);

		//$db = Zend_Registry::get('db');
		$paginator = Zend_Paginator::factory($this->_listar());
		
		$paginator
			->setItemCountPerPage($this->numero_registros)
			->setPageRange($this->rango_paginas)
			->setCurrentPageNumber($this->_getParam('page'));
			
		$this->view->data = $paginator;

		if (isset($this->no_auto_listar))
			$this->render($this->no_auto_listar);			
		else
			$this->render('z/listar',null,true); 
			
		
	}
	
	public function procesarlistaAction()
	{			
		switch ($this->_request->getParam('accion'))
		{
			case 'Borrar':
				{					
					$this->borrar_lista($this->_request->getParams());
					break;
				}
			case 'Buscar':
				{					
					$this->buscar($this->_request->getParams());
					break;
				}
			case 'Activar':
				{
					$this->activar_lista($this->_request->getParams());
					break;
				}
			case 'Desactivar':
				{					
					$this->desactivar_lista($this->_request->getParams());
					break;
				}
			case 'Reordenar':
				{				
					$this->ordenar_noticias($this->_request->getParams());
					break;
				}
			
		}
			
	}

	public function editarAction() {

		$this->view->Form->setAction($this->act.'/editar');
		$request = $this->_request;
		if ($request->isPost()) 
		{
			$form = $this->form;
			if ($form->isValid($request->getPost())) {
				
				$datos=$form->getValues();
				if(count($this->convertir_fecha))
				{
					foreach ($this->convertir_fecha as $elemento)
						$datos[$elemento]=Util_Date::normal_to_mysql($form->getElement($elemento)->getValue());										
				}
				$this->data->edit($datos);
				
				if ($form->idp)//si es un listado dependiente
					$this->_redirect($this->url.'/listar/idp/'.$form->idp->getValue());
				else
					$this->_redirect($this->url.'/listar');
				
			} else
				$form->populate($request->getPost());
		}
		else 
		{
			$id = $this->_getParam('id') ;
			$data = $this->data->find($id)->current()->toArray();
			if(isset($this->convertir_fecha)){
			if(count($this->convertir_fecha))
			{
				foreach ($this->convertir_fecha as $elemento)
					$data[$elemento]=Util_Date::mysql_to_normal($data[$elemento]);
			}
                        }
			$this->view->Form->populate($data);			
		}
		
		$this->view->pre_title="Editar";
		if(isset($this->no_auto_editar))
			$this->render($this->no_auto_editar);
		else
			$this->render('z/nofile', null, true);
	}

	public function borrarAction() {

		$id = $this->_getParam('id');
		$this->data->del($id);
		
		if($this->dependiente)
		{			
			if($this->dependiente_file)
				$this->fileExtDel($this->dependiente,$this->id,$id,$this->dependiente_file,$this->dependiente_ruta);
			
			$db=Zend_Registry::get('db');
			$db->delete($this->dependiente,$this->id.'='.$id);						
		}
		
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');
	}
	protected function borrar_lista($parametros)
	{
		$db=Zend_Registry::get('db');			
		foreach ($parametros['marcados'] as $id) 
		{
			$this->data->del($id);

			if($this->dependiente)
			{			
				if($this->dependiente_file)
					$this->fileExtDel($this->dependiente,$this->id,$id,$this->dependiente_file,$this->dependiente_ruta);				
				
				$db->delete($this->dependiente,$this->id.'='.$id);					
			}
		}
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');
		
	}
	
	
	public function fileExtDel($tabla,$key_foranea,$value_foranea,$campo_archivo,$ruta) 
	{
		$db=Zend_Registry::get('db');
		$archivos= $db->fetchAll("SELECT * FROM $tabla WHERE $key_foranea=$value_foranea");
		
		foreach ($archivos as $fila)
		{
			$file = $fila[$campo_archivo];
			if($file) 
			{
				unlink($ruta.$file);
			try {
				unlink($ruta.$this->prefijo_imagen.$file);
			}catch(Exception $e) {}
		}
		}
	}
	
	protected function activar_lista($parametros)
	{
		foreach ($parametros['marcados'] as $id) {
			$this->data->edit(array($this->data->prefijo."id"=>$id,$this->data->prefijo."estado"=>1));
		}
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');
		
	}
	
	protected function desactivar_lista($parametros)
	{
		foreach ($parametros['marcados'] as $id) {
			$this->data->edit(array($this->data->prefijo."id"=>$id,$this->data->prefijo."estado"=>0));
		}
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');
		
	}
	
	public function activarAction()
	{
		$id=$this->_request->getParam('id');
		$this->data->edit(array($this->data->prefijo."id"=>$id,$this->data->prefijo."estado"=>1));
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');		
	}
	
	public function desactivarAction()
	{
		$id=$this->_request->getParam('id');
		$this->data->edit(array($this->data->prefijo."id"=>$id,$this->data->prefijo."estado"=>0));
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');		
	}
	
private function ordenar_noticias($datos)
	{		
		$nombre_orden=$this->data->prefijo."orden";			
			
		foreach ($datos as $id=>$orden) 
		{
			$id=(int)$id;
			$orden=(int)$orden;
			if($id&&$orden)
			{
				$this->data->edit(array($this->data->prefijo."id"=>$id,$nombre_orden=>$orden));	
			}
		}
		if($_SERVER['HTTP_REFERER'])
			$this->_redirect($_SERVER['HTTP_REFERER']);
		elseif ($this->idp)//si es un listado dependiente
			$this->_redirect($this->url.'/listar/idp/'.$this->idp);
		else
			$this->_redirect($this->url.'/listar');
	}

	
}