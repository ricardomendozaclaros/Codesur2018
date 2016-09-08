<?php

class Z_Validate_Unique extends Zend_Validate_Abstract {

	const INVALID   = 'uniqueInvalid';

    protected $_db;
    protected $_table;
	protected $_field;
	protected $_primaria;

	protected $_messageTemplates = array(
		self::INVALID   => "'%value%' is not available.",
	);

	public function __construct($table, $field,$primaria=null) {

		$this->_db = Zend_Registry::get('db');
		$this->_table = $table;
		$this->_field = $field;
		$this->_primaria = $primaria;
	}

	public function isValid($value) {

		$this->_setValue($value);

		$query = $this->_db->select()->from($this->_table)->where("$this->_field = ?", $value);
		if($this->_primaria)
		{	
			$query->where($this->_primaria->getName()."<>'".$this->_primaria->getValue()."'");
		}
		
		
		if (count($this->_db->fetchAll($query))) {
			$this->_error(self::INVALID);
			return false;
		}

		return true;
	}
}
/*
 * SELECT * FROM  WHERE
 */