<?php
 
class Util_LayoutPlugin extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch ( Zend_Controller_Request_Abstract $request )
	{
		$path = APPLICATION_PATH .'/'. $this->getRequest()->getModuleName() . '/layouts';
		Zend_Layout::startMvc( array( 'layoutPath' => $path) );
	}
}