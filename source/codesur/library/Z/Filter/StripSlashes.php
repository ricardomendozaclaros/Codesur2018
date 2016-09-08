<?php

class Z_Filter_StripSlashes implements Zend_Filter_Interface {

	public function filter($value) {

		if (1 == get_magic_quotes_gpc())
			$value = stripslashes($value);
		
		return $value;
	}
}
