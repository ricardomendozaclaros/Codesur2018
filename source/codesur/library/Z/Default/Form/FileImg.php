<?php
class Z_Default_Form_FileImg extends Zend_Form_Element_File {

	public function init() {

		$this
			->setRequired(true)
			//->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorform.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,png,gif','messages'=>'El archivo debe ser una imagen'));
	}
}