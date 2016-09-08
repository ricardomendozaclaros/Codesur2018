<?php
class Z_Default_Form_Textarea extends Zend_Form_Element_Textarea {

	public function init() {

		$this
			->setAttrib('cols', '50')
			->setAttrib('rows', '5')
			->setAttrib('class', 'wymeditor')
			->setRequired(true)
			->addValidator('notEmpty',false,array('messages'=>'No puede estar vacio'))
			//->setDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorform.phtml', 'placement' => FALSE	))))
			->addFilter('StripSlashes')
		;
	}
}