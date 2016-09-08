<?php
class Z_Admin_Form extends Zend_Form {

	public function init() {

		$this->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'div')),'Form',));
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		//$element->removeDecorator('DtDdWrapper');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');

		$this->setAttrib('id','formagregar');
		$this->setAttrib('accept-charset', 'utf-8');

		$this->_init();
		
		//___________.|submit|.___________
		$this->addElement('submit', 'Guardar', array(
			'label'    => 'Guardar',
			'class'		=> 'wymupdate'
		));
		$this->Guardar->addDecorators(array(array('HtmlTag',array('tag'=>'span','class'=>'bajar'))));//ulset

		$this->setElementFilters(array('StripSlashes',array('StripTags',array('a','strong','em','sup','sub','ol','ul','li','img','br','p'), array('href')),'StringTrim'));
		
	}

	public function _init() {

	}

}
/*
 * 		$this->setE''
		$this->add->addDecorators(array(
			    array('HtmlTag', array('tag' => 'div','style'=>'clear:both')),
			));

 */