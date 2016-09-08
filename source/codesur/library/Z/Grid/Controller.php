<?php

class Z_Grid_Controller extends Zend_Controller_Action {

	public function _init() {}

	public function init() {

		$session = new Zend_Session_Namespace('loro');
		$this->country = $session->pais;

		$this->_init();

		$this->grid = (object)array_merge(array(

			'caption'=> 'Listado',
			'type'=> 'data',//tree
			'editor'=> true,
			'sortname'=> 'id',
			'sortorder'=> 'desc',
			'rowNum'=> 10,
			'rowList'=> array(10,20,30),
			//FILE
			'file'=> '',
			'upload'=> 'upload/'.$this->_request->getControllerName().'/',

			'parent'=> '',
			//SUB
			'subGridUrl'=> '',//'/admin/destacado'
			'subGridModel'=> null,//new Admin_Form_Destacado()
			//TREE
			'treeGridModel'=> 'adjacency',
			'ExpandColumn'=> '',
			//EXTRA
			'dataConstraint'=> '',
			
			'rownumbers'=> false,
			'rownumWidth'=> 25,
			'grid'=> 'grid',
			'pager'=> 'pager',
			'url'=> '/'.$this->_request->getModuleName().'/'.$this->_request->getControllerName(),
			),$this->grid);
		$this->view->Grid($this->grid);

		$this->view->grid = $this->grid;
		$this->db = Zend_Registry::get('db');
		$this->_helper->layout->disableLayout();
	}

	public function indexAction() {

		$this->_helper->layout->enableLayout();
		$this->render('z/index',null,true);
	}

	public function asyncAction() {

		$this->view->GridAsync($this->grid);
		$this->render('z/async',null,true);
	}

	public function treeAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$data = (object)$request->getPost();

		//)>--LEAF--<(
		$table = (object)$this->data->info();
		$table = $table->name;//'categoria'var_dump($table); exit();
		$query = $this->data->select()
			->from(array('c1'=>$table),array('id'))
			->joinLeft(array('c2'=>$table),'c1.id = c2.'.$this->grid->parent,array())
			->where('c2.id IS NULL')
			->where('c1.id_pais = '.$this->country)
		;
		foreach($this->data->fetchAll($query) as $row)
			$this->treeLeaf[$row['id']] = true;

		//)>--DATA--<(
		foreach($this->form->getElements() as $element)
			$fields[] = $element->getId();

		$query = $this->data->select()
			->from($this->data,$fields)
			->where('id_pais = '.$this->country)
		;
		$this->treeData = $this->data->fetchAll($query)->toArray();

		$this->tree = array();
		$this->nodes(0, 0);

		$this->view->data = $this->tree;

		$this->render('z/tree',null,true);
	}

	public function subAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$data = (object)$request->getPost();

		foreach($this->form->getElements() as $element)
			$fields[] = $element->getId();

		$query = $this->data->select()
			->from($this->data,$fields)
			->where($this->grid->parent.' = ?',$data->id)
		;

		$this->view->data = $this->db->fetchAll($query);

		$this->render('z/sub',null,true);
	}

	public function uploadAction() {

		$upload = new Zend_File_Transfer_Adapter_Http();
		foreach($upload->getFileInfo() as $name=>$file) {
			if($file['name']) {

				$filename[$name] = $this->grid->upload.$file['name'];
				$safe = new Z_Filter_File_SafeFilename();
				$filename[$name] = $safe->filter($filename[$name]);

				$upload->addFilter('Rename',$filename[$name],$name);
				$upload->receive($name);
			}
		}

		$this->view->json = basename($filename[$name]);

		$this->render('z/upload',null,true);
	}

	public function addAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$form = $this->form;
		if ($form->isValid($request->getPost())) {

			$id = $this->data->add($form->getValues());
			$file = $this->grid->file;

			if($file) {
				if($form->getValue($file))
					$this->data->edit(array(
						'id' => $id,
						$file=> $this->fileAdd($id, $form->getValue($file))
					));
			}

			$this->view->id = $id;
		}

		$this->view->form = $form;
		$this->render('z/add',null,true);
	}

	public function editAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$form = $this->form;
		if ($form->isValid($request->getPost())) {

			$data = array_intersect_key($form->getValues(),$request->getPost());
			$file = $this->grid->file;

			if($file)
				if($form->getValue($file) != ' ' ) {
					$this->data->edit(array(
						'id' => $data['id'],
						$file=> $this->fileAdd($data['id'], $form->getValue($file))
					));
				}else
					$form->removeElement($file);

			$this->data->edit($data);

		}

		$this->view->form = $form;

		$this->render('z/add',null,true);
	}

	public function delAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$this->data->del($request->getPost('id'));

		$this->_helper->viewRenderer->setNoRender();
	}

	public function gridAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$this->view->form = $this->form;

		$this->render('z/grid',null,true);
	}

	public function dataAction() {

		$request = $this->_request;
		if(!$request->isXmlHttpRequest() && !$request->isPost()) return;

		$data = (object)$request->getPost();

		foreach($this->form->getElements() as $element)
			$fields[] = $element->getId();

		$query = $this->data->select()
			->from($this->data,$fields)
			//->where('raiz = 0')
			->order($data->sidx.' '.$data->sord)
		;
		if($this->grid->dataConstraint) $query->where($this->grid->dataConstraint);
		if($data->_search == 'true')
			switch($data->searchOper) {
				case 'eq': $query->where($data->searchField.' = ?',$data->searchString); break;//.	.
				case 'ne': $query->where($data->searchField.' <> ?',$data->searchString); break;//.	.
				case 'lt': $query->where($data->searchField.' < ?',$data->searchString); break;
				case 'gt': $query->where($data->searchField.' > ?',$data->searchString); break;
				case 'le': $query->where($data->searchField.' <= ?',$data->searchString); break;
				case 'ge': $query->where($data->searchField.' >= ?',$data->searchString); break;
				case 'bw': $query->where("$data->searchField LIKE '$data->searchString%'"); break;
				case 'bn': $query->where("$data->searchField NOT LIKE '$data->searchString%'"); break;
				case 'in': $query->where("$data->searchField LIKE '%$data->searchString%'"); break;
				case 'ni': $query->where("$data->searchField NOT LIKE '%$data->searchString%'"); break;
				case 'ew': $query->where("$data->searchField LIKE '%$data->searchString'"); break;
				case 'en': $query->where("$data->searchField NOT LIKE '%$data->searchString'"); break;
				case 'cn': $query->where("$data->searchField LIKE '%$data->searchString%'"); break;
				case 'nc': $query->where("$data->searchField NOT LIKE '%$data->searchString%'"); break;
			}

		$paginator = Zend_Paginator::factory($this->db->fetchAll($query));
		$paginator
			->setItemCountPerPage($data->rows)
			->setCurrentPageNumber($data->page)
		;
		$this->view->data = $paginator;

		$this->render('z/data',null,true);
	}

	// Recursive function that do the job
	private function nodes($parent, $level) {

	//$rows = array();
	//$data = $dataSource->fetchAll("raiz = $raiz");
	//$data = array_keys($this->treeData,$parent);
		$data = $this->select($parent);
		if(count($data)) {

			foreach($data as $row) {

				$leaf = $this->treeLeaf[$row['id']] ? true : false;//
				$parent = $parent ? $parent: null;
				array_push($row, $level, $parent, $leaf, false);
				array_push($this->tree, array_values($row));
				$this->nodes($row['id'], $level+1);
			}
		}
	}

	private function select($parent) {

		$found = array();
		foreach($this->treeData as $row) {

			if($row['raiz'] == $parent)
				$found[] = $row;
		}
		//$key = array_search('raiz', $data);
		return $found;

	}

	public function fileAdd($id, $filename) {

		$new = $this->grid->upload.$id.'_'.$filename;
		$filename = $this->grid->upload.$filename;

		rename($filename, $new);

		//THUMBAIL
		try {
			$image = new Util_Image();
			$image->load($new);
			$image->resize2(150);
			$image->save(dirname($new).'/s'.basename($new));
		}catch(Exception $e) {}

		return basename($new);
	}

	public function fileDel($id) {

		$file = $this->data->find($id)->current()->toArray();
		$file = $file[$this->grid->file];

		unlink($this->grid->upload.$file);
		unlink($this->grid->upload.'s'.$file);
	}

	private function jqGrid() {

		$this->controller = $this->view->controller;
		$this->file =  $this->view->controller;

		$this->view->jQuery()->onLoadCaptureStart();
		echo <<<_
			$("#grid").jqGridImport({
				imptype:'json',
				impurl:'/admin/$this->controller/grid',
				importComplete:function(){
					$("#grid").navGrid('#pager',
						{view:false},
						{url:'/admin/$this->controller/edit',
							closeAfterEdit:false,
							afterShowForm: function(formid) {
								new AjaxUpload('#$this->file', {
									action: '/admin/$this->controller/upload',
									name: 'userfile',
									autoSubmit: true,
									responseType: 'json',
									onChange: function(file, ext){
										$('#$this->file').css({'background-color':'white','color':'black'})
									},
									onSubmit: function(file, ext) {
										if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) {
											$('#$this->file')
												.val('Uploading [' + file + ']...')
												.css({'background-color':'blue','color':'white'})
										} else {
											$('#$this->file')
												.val('Error: only images are allowed')
												.css({'background-color':'red','color':'white'})
											return false;
										}
									},
									onComplete : function(file,response){console.debug(response)//alert(response)
										$('#$this->file')
											.val(file)
											.css({'background-color':'green','color':'white'})
									}
								});
/**/							},
							afterSubmit: function(response, postdata) {
								var json = eval('('+response.responseText+')')
								return [json.success,json.message,json.id]
							}
						},
						{url:'/admin/$this->controller/add',
							closeAfterAdd:true,
							//editData:{raiz:$('#grid').getGridParam('selrow')},
							beforeSubmit: function(postdata, formid) {console.debug($('#grid').getGridParam('selrow'))
								$('input#raiz').val($('#grid').getGridParam('selrow'))
								return [true,'']
							},
							beforeInitData: function(formid) {
								$('input#raiz').val($('#grid').getGridParam('selrow'))
							},
							afterShowForm: function(formid) {//alert($('#grid').getGridParam('selrow'))
								$('input#raiz').val($('#grid').getGridParam('selrow'))
/*
	$('.wymeditor').wymeditor({
		lang: 'es',
		boxHtml:
		"<div class='wym_box'>"
		+ "<div class='wym_area_top'>"
		+ WYMeditor.TOOLS
		+ "</div>"
		+ "<div class='wym_area_left'></div>"
		+ "<div class='wym_area_right'>"
		+ "</div>"
		+ "<div class='wym_area_main'>"
		+ WYMeditor.HTML
		+ WYMeditor.IFRAME
		+ WYMeditor.STATUS
		+ "</div>"
		+ "<div class='wym_area_bottom'>"
		+ "</div>"
		+ "</div>"
	});
*/
								new AjaxUpload('#$this->file', {
									action: '/admin/$this->controller/upload',
									name: 'userfile',
									autoSubmit: true,
									responseType: 'json',
									onChange: function(file, ext){
										$('#$this->file').css({'background-color':'white','color':'black'})
									},
									onSubmit: function(file, ext) {
										if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) {
											$('#$this->file')
												.val('Uploading [' + file + ']...')
												.css({'background-color':'blue','color':'white'})
										} else {
											$('#$this->file')
												.val('Error: only images are allowed')
												.css({'background-color':'red','color':'white'})
											return false;
										}
									},
									onComplete : function(file,response){alert(response)//
										$('#$this->file')
											.val(file)
											.css({'background-color':'green','color':'white'})
									}
								});
							},
							afterSubmit: function(response, postdata) {
								var json = eval('('+response.responseText+')')
								return [json.success,json.message,json.id]
							}
						},
						{url:'/admin/$this->controller/del',
							width: 400
						},
						{}
					)
					/*
					.navButtonAdd('#pager',{
						caption:"Toggle",
						title:"Toggle Search Toolbar",
						buttonicon :'ui-icon-pin-s',
						onClickButton:function(){
							$('#grid')[0].toggleToolbar()
						}
					})
					.navButtonAdd('#pager',{
						caption:"Clear",
						title:"Clear Search",
						buttonicon :'ui-icon-refresh',
						onClickButton:function(){
							$('#grid')[0].clearToolbar()
						}
					})
					.filterToolbar();
					*/
 				}
			});
_;
		$this->view->jQuery()->onLoadCaptureEnd();
	}

}

/*
 * s'', sub
 */