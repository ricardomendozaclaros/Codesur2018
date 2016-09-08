<?php

class Z_Filter_File_SafeFilename extends Z_Filter_Transliterate {

	public function filter($value) {

		$trans = parent::filter($value);

		$trans = preg_replace('/^\W+|\W+$/', '', $trans);
		$trans = preg_replace('/\W-/', '', $trans);

		return strtolower($trans);
	}
}
