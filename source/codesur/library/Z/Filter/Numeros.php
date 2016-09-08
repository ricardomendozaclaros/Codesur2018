<?php

class Z_Filter_Numeros implements Zend_Filter_Interface {

	public function filter($value) {

		$tofind = ".,'";
		$replac = "000";
		$cadena_sin_puntos=strtr($value,$tofind,$replac);
		
		return "100";
	}
}
