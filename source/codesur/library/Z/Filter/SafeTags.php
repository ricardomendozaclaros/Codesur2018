<?php

class Z_Filter_SafeTags implements Zend_Filter_Interface {

    /*public function __construct() {

        $this->setTagsAllowed();
        
        $this->setCommentsAllowed(null);
    }*/
	public function filter($value) 
	{		
		$filtro=new Zend_Filter_StripTags();		
		$filtro->setTagsAllowed(array('a','span','strong','em','sup','sub','ol','ul','li','img','br','p','h1','h2','h3','h4','h5','h6','address','pre','table','tr','td','th','tbody','thead','tfoot'));
		$filtro->setAttributesAllowed(array('href','style'));			
		return $filtro->filter($value);
	}
}
