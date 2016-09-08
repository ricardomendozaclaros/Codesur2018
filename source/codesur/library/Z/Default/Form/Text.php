<?php
class Z_Default_Form_Text extends Zend_Form_Element_Text {

	public function init() {

		$this
			->setRequired(true)
			->addValidator('notEmpty',false,array('messages'=>'No puede estar vacio'))
			//->setDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorform.phtml', 'placement' => FALSE))))
			->addFilter('StripSlashes')
		;

	}
}