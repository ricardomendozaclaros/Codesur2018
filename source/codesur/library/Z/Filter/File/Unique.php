<?php

class Z_Filter_File_Unique extends Zend_Filter_File_Rename {

	public function __construct($filename) {

		$safe = new Z_Filter_SafeFilename();
		$filename = $id.'_'.$key.'_'.$safe->filter($value['name']);
		parent::__construct($filename);

	}

	public function filter($value) {

		return parent::filter($content);

	}
}
