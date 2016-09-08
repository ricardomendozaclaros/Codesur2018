<?php

class Z_Grid_View_Helper_GridAsync extends Zend_View_Helper_Abstract {

	protected $_url;

	protected $_grid;
	protected $_pager;

	protected $_file;
	protected $_editor;

	function gridasync($options) {

		$this->_url = $options->url;
		$this->_file =  $options->file;
		$this->_editor = $options->editor;

		$this->_grid = $options->grid;
		$this->_pager = $options->pager;

		$this->view->jQuery()->javascriptCaptureStart();
		echo <<<_
			$('#$this->_grid').jqGridImport({
				imptype:'json',
				impurl:'$this->_url/grid',

				importComplete:function(){
					$('#$this->_grid').navGrid('#$this->_pager',
						{
							view:false
						},
						{url:'$this->_url/edit',
							closeAfterEdit:false,
							afterShowForm: function(formid) {
								{$this->upload()}
								{$this->editor()}
							},
							afterSubmit: function(response, postdata) {
								var json = eval('('+response.responseText+')')
								return [json.success,json.message,json.id]
							}
						},
						{url:'$this->_url/add',
							closeAfterAdd:false,//true
							afterShowForm: function(formid) {
								{$this->upload()}
								{$this->editor()}
								$('input#$options->parent').val($('#$this->_grid').getGridParam('selrow'))//
							},
							afterSubmit: function(response, postdata) {
								var json = eval('('+response.responseText+')')
								return [json.success,json.message,json.id]
							}
						},
						{url:'$this->_url/del',
							width: 400
						},
						{}
					)
 				}
			});
_;
		$this->view->jQuery()->javascriptCaptureEnd();
	}

	private function upload() {

		if($this->_file)
		return <<<_
			new AjaxUpload('#$this->_file', {
				action: '$this->_url/upload',
				name: 'userfile',
				autoSubmit: true,
				responseType: 'json',
				onChange: function(file, ext){
					$('#$this->_file').css({'background-color':'white','color':'black'})
				},
				onSubmit: function(file, ext) {
					if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) {
						$('#$this->_file')
							.val('Uploading [' + file + ']...')
							.css({'background-color':'blue','color':'white'})
					} else {
						$('#$this->_file')
							.val('Error: only images are allowed')
							.css({'background-color':'red','color':'white'})
						return false;
					}
				},
				onComplete : function(file,response){
					$('#$this->_file')
						.val(response)
						.css({'background-color':'green','color':'white'})
				}
			});
_;
		return '';
	}

	private function editor() {

		if($this->_editor)
		return <<<_
			try {
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
			} catch(e){}
_;
		return '';
	}
}