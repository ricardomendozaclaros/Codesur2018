<?php

class Z_Filter_Nl2br implements Zend_Filter_Interface {

	public function filter($value) 
	{
		return nl2br($value);
	}
}
