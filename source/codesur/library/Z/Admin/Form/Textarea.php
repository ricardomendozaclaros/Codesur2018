<?php
class Z_Admin_Form_Textarea extends Zend_Form_Element_Textarea {

	public function init() {

		$this
			//->setAttrib('cols', '50')
			//->setAttrib('rows', '5')
			//->setAttrib('class', 'tinymce')
			//->setRequired(true)
			//->addValidator('notEmpty',false,array('messages'=>'No puede estar vacio'))
			->setDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE	))))
			//->addFilter('StripSlashes')
			//->addFilter(new Zend_Filter_StripTags(array('a'), array('href','style')))
		;
	}
}