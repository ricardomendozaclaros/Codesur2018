<?php
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap {
	
	public function _initNavigation_() 
	{

		Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/menu.ini')));
	}
        public function _initRutas()
	{
		$front=Zend_Controller_Front::getInstance()->getRouter();
                $front=Zend_Controller_Front::getInstance()->getRouter();
                $front->addRoute('lang_en', // nombre de la ruta
    		new Zend_Controller_Router_Route('/:lang/:module/:controller/:action',
        								array('lang' =>	':lang',)
    										));
                //-------------------RFC--------------------------------//
		
                $front->addRoute('registro_factura', // nombre de la ruta
    		new Zend_Controller_Router_Route('reg_fact/:id',
                                        array('module' =>'admin',
                                          'controller' => 'facturas',
                                          'action'     => 'regfact',	  
                                          'id' => '')        								
                                                )); 
               
                
        }
}

//class Admin_Bootstrap extends Zend_Application_Module_Bootstrap {
//	
//	public function _initNavigation_() 
//	{
//		Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/menu.ini')));
//		$datos=Zend_Auth::getInstance()->getIdentity();	
//              
//		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl( new Util_Acl());
//		Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($datos->rol);
//	}
//
//	
//
//}
