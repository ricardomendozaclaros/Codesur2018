<?php
class Admin_BannerimgController extends Z_Admin_ControllerFile {

	public function _init() {

		/*indespensables*/
		$this->url  = '/admin/bannerimg';
		$this->data = new Model_Banner_Banner();			
		$this->form = new Admin_Form_Banner_Img();
		$this->view->title = 'Banner';
		
		/*para subir archivos*/
		$this->file = array('ban_img_es','ban_img_en');
		$this->upload = array('upload/banner/','upload/banner/');
		$this->resize=array(false);
		$this->thumb=array(false);
		$this->img_size=array(null);
		$this->thumb_size=array(null);
		$this->nro_imgs=1;		
		
		/*listado*/
		$this->numero_registros=20;
		$this->rango_paginas=20;
		$this->view->hidden=array('id');
		
		/*son imagenes y se mostraran como tales*/
		$this->view->imagenes=array('Imagen (ES)');
		
		$this->view->edit_img=true;
		
		//$this->view->file=array('ban_img');
		
		/*clasificar por un campo especifico(la consulta debe ordenar previamente los resultados por ese campo)*/
		$this->view->clasificar='Posición';
		
	}
	
	
	
	public function _listar() {
		
		$db = Zend_Registry::get ( 'db' );		
        $select = $db->select ()
                 ->from (array('b'=>$this->data->info('name')),
                 array('id'=>'b.ban_id',
                 	   'Nombre'=>'b.ban_nombre_es',
                 	   'Imagen (ES)'=>'b.ban_img_es',                 	   
                 	   'Posición'=>'p.pos_nombre',
                 	   'Fecha Creación'=>new Zend_Db_Expr("DATE_FORMAT(b.ban_fecha_creacion,'%d/%m/%y')")
                 ))
                 ->join(array('p'=>'banner_posicion'),"b.pos_id=p.pos_id",array())                 
                 ->order(array("p.pos_id","b.ban_id"))                 
                 ;                
         
		return $select;		
	}	
	
	
public function editarAction() {
		$this->view->Form->removeElement("pos_id");
		$this->view->Form->setAction($this->act.'/editar');		
		if($this->no_edit_img){for ($i=0;$i<=$this->nro_imgs-1;$i++){$this->form->removeElement($this->file[$i]);}}
		
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
		{
			if(count($this->convertir_fecha))
			{
				foreach ($this->convertir_fecha as $elemento)
					$data[$elemento]=Util_Date::mysql_to_normal($data[$elemento]);
			}
			
			$this->view->Form->populate($data);
			$this->view->Form->setAction($this->act.'/editar');//.	.
		}
		$this->view->pre_title="Editar";
		if($this->no_auto_editar)
			$this->render($this->no_auto_editar);
		else		
			$this->render('z/files', null, true);
	}
		
}