<?php

class Z_Filter_SafeFilename implements Zend_Filter_Interface {

	/**
	 * Sets default option values for this instance
	 *
	 * @param  boolean $allowWhiteSpace
	 * @return void
	 */
	public function __construct() {

	}

	/**
	 * Defined by Zend_Filter_Interface
	 *
	 * Returns the string $value, removing all but alphabetic characters
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($value) {

		$tofind = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ';
		$replac = 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn_';
		$clean = strtr(utf8_decode($value), utf8_decode($tofind), $replac);

		return utf8_encode(ereg_replace('[^a-zA-Z0-9_.]','',$clean));
	}
}
