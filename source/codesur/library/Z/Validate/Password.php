<?php

class Z_Validate_Password extends Zend_Validate_Abstract {

	const INVALID   = 'passwordInvalid';
	const TOO_SHORT = 'passwordInvalidShort';
	const TOO_LONG  = 'passwordInvalidLong';

    public $minimum;
    public $maximum;
	
    protected $_messageVariables = array(
        'min' => 'minimum',
        'max' => 'maximum'
    );

	protected $_messageTemplates = array(
		self::INVALID   => "Must contains characters or numbers only",
		self::TOO_SHORT => "Must be at least '%min%' in length",
		self::TOO_LONG  => "Must not be larger than '%max%' in length",
	);

	public function __construct($min = 6, $max = 20) {

		$this->minimum = $min;
		$this->maximum = $max;
	}

	public function isValid($value) {

		$this->_setValue($value);

		$isValid = true;

		if (!preg_match('/^([a-zA-Z]|[0-9])/i', $value)) {
			$this->_error(self::INVALID);
			$isValid = false;
		}

        if (strlen($value) < $this->minimum) {
            $this->_error(self::TOO_SHORT);
			$isValid = false;
        }

        if (strlen($value) > $this->maximum) {
            $this->_error(self::TOO_LONG);
			$isValid = false;
        }

		return $isValid;
	}
}
