<?php
class Admin_NoticiaController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/noticia';
		$this->data = new Model_Noticia_Noticia();			
		$this->form = new Admin_Form_Noticia_Noticia();
		$this->view->title = 'Noticias';
		
		/*para subir archivos*/
		$this->file = array('not_img');
		$this->upload = array('upload/noticia/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>900,'height'=>550));
		$this->thumb_size=array(array('width'=>300,'height'=>200));
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','orden');
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen');
		
		$this->view->edit_img=true;
	
                
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		//$this->view->clasificar='Posici��n';
		
		$this->view->orden=true;
		
		//$this->no_auto_listar='listar';
		
		$this->form->not_pos->setValue("1");
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('n'=>$this->data->info('name')),
                 array('id'=>'n.not_id',
                 		'orden'=>'n.not_orden',
                       'Imagen'=>'not_img',
                 	   'Posicion'=>new Zend_Db_Expr("CASE not_pos WHEN 1 THEN 'Principal' WHEN 2 THEN 'Secundaria' WHEN 4 THEN 'Rotador' ELSE 'Error' END"),
                 	   'Titulo'=>'n.not_titulo_es',
                           'Ante titulo'=>'n.not_antetitulo_es',
                 	   'Fecha Creacion'=>new Zend_Db_Expr("DATE_FORMAT(n.not_fecha_creacion,'%d/%m/%y')"),
                           'Mostrar'=>new Zend_Db_Expr("CASE not_estado WHEN 1 THEN 'Si' WHEN 2 THEN 'No' ELSE 'Error' END"),
                 ))
                 //->where("not_pos=1")
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
		if(isset($this->no_auto_agregar))
			$this->render($this->no_auto_agregar);
		else		
			$this->render('z/files', null, true);
	}
	
	function obtener_orden(){
		$fila=$this->data->fetchRow("not_pos=1",$this->data->prefijo."orden DESC");
		if($fila)$fila->toArray();
		$n_orden=(int)$fila[$this->data->prefijo."orden"];
		return $n_orden;
	}
	/***************************************************************************************/
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
				//$this->_redirect($this->url.'/listar');
                                $this->_redirect($this->url.'/editar/id/'.$id);///id/.$id
				
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
//		if(isset($this->no_auto_editar))
//			$this->render($this->no_auto_editar);
//		else		
//			$this->render('z/files', null, true);
	}	
}