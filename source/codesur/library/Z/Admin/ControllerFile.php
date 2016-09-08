<?php
class Z_Admin_ControllerFile extends Zend_Controller_Action {

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
		
		$this->prefijo_thumb="s";
		$this->directorio_thumb="thumb/";
		//$this->prefijo_imagen="s";
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
		$sesion_agregar=new Zend_Session_Namespace('agregar');
		$sesion_agregar->id=rand(0,9999);
		
		
		$this->view->pre_title="Agregar";
		if(isset($this->no_auto_agregar))
			$this->render($this->no_auto_agregar);
		else		
			$this->render('z/files', null, true);
	}
	
	
	public function agregarAction() {
		
		$request = $this->_request;
		//print_r($this->_request->getParams());exit();
		if ($request->isPost()) {
			$form = $this->form;
			//$file = eval('return $form->'.$this->file.';');
			
			for ($i=0;$i<=$this->nro_imgs-1;$i++)
			{
				if($form->getElement($this->file[$i])->isUploaded())
				{
					$file[$i] = $form->getElement($this->file[$i]);
					$file[$i]->setDestination($this->upload[$i]);
					$filename = $file[$i]->getFileInfo();					
					$filename = $filename[$this->file[$i]]['name'];					
					$file[$i]->addFilter('Rename',array('target'=>strtolower($this->upload[$i]."-".Util_Cortartexto::limpiar($filename)),'overwrite' => false));
				}
			}
			
			
			if ($form->isValid($request->getPost())) {

			$datos=$form->getValues();
			for ($i=0;$i<=$this->nro_imgs-1;$i++)
			{
				unset($datos[$this->file[$i]]);
			}
			
			if(count($this->convertir_fecha))
			{
				foreach ($this->convertir_fecha as $elemento)
					$datos[$elemento]=Util_Date::normal_to_mysql($form->getElement($elemento)->getValue());										
			}
			$id = $this->data->add($datos);
				
			for ($i=0;$i<=$this->nro_imgs-1;$i++)
			{				
				if($form->getElement($this->file[$i])->isUploaded())
				{					
					$filename = $this->fileAdd($id, $file[$i],$i);
					
				/*	try 
					{
						$image = new Util_Image();
						$image->load($this->upload[$i].$filename);
						$formData['img_width']=$image->getWidth();
						$formData['img_height']=$image->getHeight();
						unset($image);				
					}	
					catch(Exception $e) 
					{
						$error_table=new Admin_Model_Error();$error_table->add(array('tipo'=>'redimensionar imagen','nombre'=>$this->view->title,'error'=>$e));
					}
					*/
					
					$formData[$this->file[$i]] = $filename;
					
					if($this->data_img)
					{
						$formData[$this->llave_foranea] = $id;					
						$this->data_img->add($formData);
					}
					else
					{	
						$formData[$this->id] = $id;					
						$this->data->edit($formData);
					}
				}
			}				
				
//			if ($form->idp)//si es un listado dependiente
//				$this->_redirect($this->url.'/listar/idp/'.$form->idp->getValue());
//			else
				$this->_redirect($this->url.'/listar');
				
			} else
				$form->populate($request->getPost());
		}
		
		$this->view->pre_title="Agregar";
		if($this->no_auto_agregar)
			$this->render($this->no_auto_agregar);
		else		
			$this->render('z/files', null, true);
	}

	
	public function editarAction() {
		$this->view->Form->setAction($this->act.'/editar');
                $imagenes="";
                $rutas="";
		if(isset($this->no_edit_img)){for ($i=0;$i<=$this->nro_imgs-1;$i++){$this->form->removeElement($this->file[$i]);}}
		
		$request = $this->_request;
		$id = $this->_getParam('id') ;
		if($this->_request->isPost())
			$id=$this->_request->getParam($this->id);
		$data = $this->data->find($id)->current()->toArray();
		//echo $id;
		
		for ($i=0;$i<=$this->nro_imgs-1;$i++)		
		{			
			if($data[$this->file[$i]])
			{	$imagenes[$this->file[$i]]=$data[$this->file[$i]];
				$rutas[$this->file[$i]]=$this->upload[$i];
				$this->form->getElement($this->file[$i])->setRequired(false);
			}						
				
		}		
		
		$this->view->imagenes=$imagenes;
		$this->view->rutas=$rutas;
		if ($request->isPost()) {//
			$data = $this->data->find($id)->current()->toArray();
			
			$form = $this->form;			
			for ($i=0;$i<=$this->nro_imgs-1;$i++)
			{
				$e=$form->getElement($this->file[$i]);
				if($e->isUploaded())
				{
					$file[$i] = $form->getElement($this->file[$i]);
					$file[$i]->setDestination($this->upload[$i]);
					$filename = $file[$i]->getFileInfo();
					//$tempname=$filename[$this->file[$i]]['tmp_name'];					
					$filename = $filename[$this->file[$i]]['name'];		
					$file[$i]->addFilter('Rename',array('target'=>strtolower($this->upload[$i]."-".Util_Cortartexto::limpiar($filename)),'overwrite' => false));					
				}
				else 
				{
					if($data[$e->getName()])
						$e->setRequired(false);
				}
			}
			
			
			if ($form->isValid($request->getPost())) 
			{
				$id=$data[$this->id];
				$datos=$form->getValues();				
				for ($i=0;$i<=$this->nro_imgs-1;$i++)
				{
					unset($datos[$this->file[$i]]);
				}
				if(count($this->convertir_fecha))
				{
					foreach ($this->convertir_fecha as $elemento)
						$datos[$elemento]=Util_Date::normal_to_mysql($form->getElement($elemento)->getValue());										
				}	
				$this->data->edit($datos);
				for ($i=0;$i<=$this->nro_imgs-1;$i++)
				{				
					if($form->getElement($this->file[$i])->isUploaded())
					{	
					
						$file_stored = $data[$this->file[$i]];
						if($file_stored)
						{
							@unlink($this->upload[$i].$file_stored);
							try {
							@unlink($this->upload[$i].$this->directorio_thumb.$this->prefijo_thumb.$file_stored);
							}catch(Exception $e) {}
						}
							
						$filename = $this->fileAdd($id, $file[$i],$i);
						
						/*						
						try 
						{
							$image = new Util_Image();
							$image->load($this->upload[$i].$filename);
							$formData['img_width']=$image->getWidth();
							$formData['img_height']=$image->getHeight();
							unset($image);				
						}	
						catch(Exception $e) 
						{
							$error_table=new Admin_Model_Error();$error_table->add(array('tipo'=>'redimensionar imagen','nombre'=>$this->view->title,'error'=>$e));
						}
						*/
						
						$formData=null;
						$formData[$this->file[$i]] = $filename;
						
						if($this->data_img)
						{
							$formData[$this->llave_foranea] = $id;					
							$this->data_img->add($formData);
						}
						else
						{						
							$formData[$this->id] = $id;					
							$this->data->edit($formData);
						}
					}
				}	
				
				
//			if ($form->idp)//si es un listado dependiente
//				$this->_redirect($this->url.'/listar/idp/'.$form->idp->getValue());
//			else
				$this->_redirect($this->url.'/listar');
					
			} 
			else
			{	$form->populate($request->getPost());
				$this->view->Form->setAction($this->act.'/editar');
			}
		}
		else 
		{   if(isset($this->convertir_fecha)){
			if(count($this->convertir_fecha))
			{
				foreach ($this->convertir_fecha as $elemento)
					$data[$elemento]=Util_Date::mysql_to_normal($data[$elemento]);
			}
                }
			$this->view->Form->populate($data);
			$this->view->Form->setAction($this->act.'/editar');//.	.
		}
		$this->view->pre_title="Editar";
		if(isset($this->no_auto_editar))
			$this->render($this->no_auto_editar);
		else		
			$this->render('z/files', null, true);
	}
	
	public function listarAction() {

		//$this->render('z/index', null, true);
		//$this->view->imagenes=$this->file;
		$this->view->rutas=$this->upload;
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

	

	public function borrarAction() {

		$id =$this->_getParam('id');
		
		if($this->dataimg)
			$this->filesDel($id);
		else 
			$this->fileDel($id);
		
	
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
		foreach ($parametros['marcados'] as $id) {
			if($this->dataimg)
				$this->filesDel($id);
			else 
				$this->fileDel($id);
				
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
	public function borrarimgAction() {

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
		if($this->_request->isXmlHttpRequest())
		{
			$id=$this->_request->getParam('id');
			$nombre=$this->_request->getParam('nombre');

			if(isset($this->data_img))			
				$data=$this->data_img->fetchRow($this->id_img.'='.(int)$id);
			else 
				$data=$this->data->fetchRow($this->id.'='.(int)$id);			
			
			if($data)
				$data=$data->toArray();
			
				
			for ($i=0;$i<=$this->nro_imgs-1;$i++)		
			{				
				if($data[$this->file[$i]])
				{	$imagenes[$this->file[$i]]=$data[$this->file[$i]];
					$rutas[$this->file[$i]]=$this->upload[$i];
				}	
			}		
		
			if($imagenes[$nombre])
			{			
				try {
				@unlink($rutas[$nombre].$data[$nombre]);
				@unlink($rutas[$nombre].$this->directorio_thumb.$this->prefijo_thumb.$data[$nombre]);
				}
				catch(Exception $e){echo "no se pudo borrar la imagen";exit();}
				
				
				if(isset($this->data_img))
					$this->data_img->del(array($this->id_img=>(int)$data[$this->id_img]));
				else 						
					$this->data->edit(array($this->id=>(int)$data[$this->id],$nombre=>''));
				
					
				echo "imagen eliminada";exit();
			}	
			
		}
	}
	
	

	
	public function fileAdd($id, $file,$i) {

		$filename = $file->getFileInfo();
		$filename = $filename[$this->file[$i]]['name'];
		$filename = $id.$i.$filename;
		rename($file->getFileName(),$this->upload[$i].$filename);
		if($this->resize[$i])
		{
			try {
				$image = new Util_Image();
				$image->load($this->upload[$i].$filename);
				$image->redimensionar($this->img_size[$i]);
				$image->save($this->upload[$i].$filename);
				if($this->thumb[$i])
				{
					$image->redimensionar($this->thumb_size[$i]);
					$image->save($this->upload[$i].$this->directorio_thumb.$this->prefijo_thumb.$filename);
				}
			}catch(Exception $e) {$error_table=new Admin_Model_Error();$error_table->add(array('tipo'=>'redimensionar imagen','nombre'=>$this->view->title,'error'=>$e));}
		}
		
		if($this->thumb[$i])
		{
			try {
				$image = new Util_Image();
				$image->load($this->upload[$i].$filename);
				$image->redimensionar($this->thumb_size[$i]);
				$image->save($this->upload[$i].$this->directorio_thumb.$this->prefijo_thumb.$filename);
				}
			catch(Exception $e) {$error_table=new Admin_Model_Error();$error_table->add(array('tipo'=>'redimensionar imagen','nombre'=>$this->view->title,'error'=>$e));}	
		}
		
		unset($image);
		return $filename;
	}
	
	
	public function fileDel($id) {

		$row= $this->data->find($id)->current()->toArray();
		
		for($i=0;$i<=$this->nro_imgs-1;$i++)
		{
			$file = $row[$this->file[$i]];
			if($file) {
			unlink($this->upload[$i].$file);
			try {
				unlink($this->upload[$i].$this->directorio_thumb.$this->prefijo_thumb.$file);
			}catch(Exception $e) {}
		}
		}
	}
	public function filesDel($id) {

		$tabla = $this->dataimg->fetchAll($this->llave_foranea.'='.(int)$id)->toArray();		
		foreach ($tabla as $fila)
		{			
			$file = $fila[$this->file[0]];
			if($file) {
				unlink($this->upload.$file);
				try {
					unlink($this->upload.$this->directorio_thumb.$this->prefijo_thumb.$file);
				}catch(Exception $e) {}
			}
			$this->dataimg->del(array('id'=>$fila['id']));
		}
	}
	
	
	
/*ACTIVAR DESACTIVAR*/
	
	
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
	
public function fileExtDel($tabla,$key_foranea,$value_foranea,$array_campo_archivo,$ruta) 
	{
		$db=Zend_Registry::get('db');
		$archivos= $db->fetchAll("SELECT * FROM $tabla WHERE $key_foranea=$value_foranea");
		
		foreach ($archivos as $fila)
		{
			foreach ($array_campo_archivo as $campo_archivo) 
			{
				$file = $fila[$campo_archivo];
				if($file) 
				{
					unlink($ruta.$file);
				try {
					unlink($ruta.$this->directorio_thumb.$this->prefijo_thumb.$file);					
					}catch(Exception $e) {}	
				}
			
			}
		}
	}
}