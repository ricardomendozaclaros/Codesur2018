<?php

class Z_Filter_BuscarYt implements Zend_Filter_Interface {

    public function filter($value) 
	{	
		return Util_Yt::buscarvideo($value);
	}
}
