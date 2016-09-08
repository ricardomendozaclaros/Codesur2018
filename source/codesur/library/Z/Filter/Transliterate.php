<?php

class Z_Filter_Transliterate implements Zend_Filter_Interface {

	public function filter($value) {

		$tofind = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ';
		$replac = 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn_';
		$trans = strtr(utf8_decode($value), utf8_decode($tofind), $replac);

		return utf8_encode($trans);
	}
}
