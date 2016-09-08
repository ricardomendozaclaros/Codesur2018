<?php

class Z_Validate_EmailsAddress extends Zend_Validate_Abstract {

	const INVALID   = 'emailInvalid';

    
	//protected $_field;	

	protected $_messageTemplates = array(
		self::INVALID   => "'%value%' contains one or more invalid email addresses",
	);

	public function __construct() {

		
	}

	public function isValid($value) {

		$this->_setValue($value);

		$valida_mail=new Zend_Validate_EmailAddress();
		$emails=explode(',',$value);
		foreach ($emails as $email) 
		{
			if(!$valida_mail->isValid($email))
			{
				$email_no_valido=$email;
				break;				
			}			
		}
		
		
		
		if ($email_no_valido) 
		{
			$this->_error(self::INVALID);
			return false;
		}

		return true;
	}
}
/*
 * SELECT * FROM  WHERE
 */