<?php
class Z_Admin_Form_FilePdf extends Zend_Form_Element_File {

	public function init() {

		$this
                ->setRequired(true)
                ->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorform.phtml', 'placement' => FALSE))))
                ->addValidator('Count', false, array(1,'messages'=>'Debe subir un archivo de tipo pdf'))
                ->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo acpetado 2MB'))
                ->addValidator('Extension', false, array('pdf','messages'=>'El archivo debe ser pdf'));
	}
}