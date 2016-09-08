<?php
class Admin_ImagenesnoticiaController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/imagenesnoticia';
		$this->data = new Model_Noticia_Imagenes();			
		$this->form = new Admin_Form_Noticia_Imagenes();
		$this->view->title = 'Imagenes';
		
				
		
		/*para subir archivos*/
//		$this->file = array('img_img');
//                $this->upload = array(null);
//                $this->resize=array(true);
//		$this->thumb=array(true);
//		$this->img_size=array(450);
//		$this->thumb_size=array(180);
//		$this->nro_imgs=1;
                $this->file = array('img_img');
		$this->upload = array('upload/noticia/');
		$this->resize=array(true);
		$this->thumb=array(true);
		$this->img_size=array(array('width'=>900,'height'=>550));
		$this->thumb_size=array(array('width'=>300,'height'=>200));
		$this->nro_imgs=1;

             


		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id','id_noticia','img','orden');
		$this->view->imagenes=array('Imagen');
		$this->view->edit_img=true;

		
		
		$sesion_img=new Zend_Session_Namespace('noticia_img');//var_dump($sesion_img->not_id);
		if($this->_request->isPost()&&$this->_request->getParam('noticia_id'))
		{
			$sesion_img->not_id=$this->_request->getParam('noticia_id');
			
			
		}
		if($sesion_img->not_id)
		{
			$this->not_id=$sesion_img->not_id;
			$this->form->not_id->setValue($sesion_img->not_id);
			$this->view->volver="/admin/noticia/editar/id/".$sesion_img->not_id;		
		}
		else 
			$this->not_id=0;
			
		$model_not=new Model_Noticia_Noticia();
		$fila=$model_not->find($sesion_img->not_id)->current()->toArray();
		$this->view->mensaje="Imagenes para la noticia:".$fila['not_titulo_es'];	
                $this->not_id=$sesion_img->not_id;
		
		$this->upload = array('upload/noticia/');
		$this->view->orden=true;
		/*intentar calcular tamaño(alto i ancho de la imagen)*/
		//$this->calcular_tamano_img=array('width'=>'img_width','height'=>'img_heigth');
	
	}
	
	
	
	public function _listar() {
		$this->auto_listar=true;
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('i'=>$this->data->info('name')),
                 array('id'=>'img_id',
                 	   'id_noticia'=>'not_id',
                           'orden'=>'img_orden',
                           'Titulo'=>'img_titulo_es',
                 	   'img'=>'img_img',
                           'Imagen'=>'img_img',
                 	   //'Posición Portada'=>'p.img_pos_nombre',
//                       'Posición Sección'=>'p2.img_pos_nombre',
                 	   //'Fecha Creación'=>'img_fecha_creacion'
                 	   'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(img_fecha_creacion,'%d/%m/%y')"),
                 		))
                // ->from (array('p'=>'noticia_img_posicion'),array())
              //   ->joinleft(array('p2'=>'noticia_img_posicion'),"i.img_pos_sec_id=p2.img_pos_id",array())
               //  ->where("i.img_pos_id=p.img_pos_id")                 
                 ->where("not_id='".$this->not_id."'")
                 ;
                 
         
		return $select;		
	}
	
	

			
			
	public function indexAction() 
	{		$orden=0;
		
		$tabla_imagenes=$this->data->fetchAll("not_id=".$this->not_id);	
//		foreach ($tabla_imagenes as $fila_imagen)		
//		{	
//			//if($fila_imagen['img_pos_id']!=11)
//				//$this->form->img_pos_id->removeMultiOption($fila_imagen['img_pos_id']);
//			if($fila_imagen['img_pos_sec_id']!=11)
//				$this->form->img_pos_sec_id->removeMultiOption($fila_imagen['img_pos_sec_id']);
//			
//		}
		
		//echo $this->data->prefijo."orden";
		//exit();
		$orden=$this->view->Form->getElement($this->data->prefijo."orden");
		if($orden)
		{
			$fila=$this->data->fetchRow(null,$this->data->prefijo."orden DESC");
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
	

	

	
	public function editarAction() {
		$this->view->Form->setAction($this->act.'/editar');		
		if(isset($this->no_edit_img)){for ($i=0;$i<=$this->nro_imgs-1;$i++){$this->form->removeElement($this->file[$i]);}}
		
		$request = $this->_request;
		$id = $this->_getParam('id') ;
		if($this->_request->isPost())
			$id=$this->_request->getParam($this->id);
		$data = $this->data->find($id)->current()->toArray();
				
		$tabla_imagenes=$this->data->fetchAll("not_id=".$this->not_id);	
		foreach ($tabla_imagenes as $fila_imagen)		
		{	
			//if($fila_imagen['img_pos_id']!=11&&$data['img_pos_id']!=$fila_imagen['img_pos_id'])
				//$this->form->img_pos_id->removeMultiOption($fila_imagen['img_pos_id']);
//			if($fila_imagen['img_pos_sec_id']!=11&&$data['img_pos_sec_id']!=$fila_imagen['img_pos_sec_id'])
//				$this->form->img_pos_sec_id->removeMultiOption($fila_imagen['img_pos_sec_id']);
			
		}
		
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
				
				
			if ($form->idp)//si es un listado dependiente
				$this->_redirect($this->url.'/listar/idp/'.$form->idp->getValue());
			else
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

}