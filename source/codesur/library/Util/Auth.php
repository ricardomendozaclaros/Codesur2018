<?php
class Util_Auth extends Zend_Controller_Plugin_Abstract {
	protected $_auth;
	protected $_acl;

	const NO_AUTH_MODULE    = 'admin';
	const NO_AUTH_CONTROLLER = 'login';
	const NO_AUTH_ACTION     = 'index';

	const USUARIO_NO_AUTH_MODULE    = 'default';
	const USUARIO_NO_AUTH_CONTROLLER = 'error';
	const USUARIO_NO_AUTH_ACTION     = 'pagina';

	const NO_ACL_MODULE     = 'default';
	const NO_ACL_CONTROLLER  = 'error';
	const NO_ACL_ACTION      = 'login';

	public function __construct() {
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = Zend_Registry::get( 'Zend_Acl' );
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request) {

		if ($this->_auth->hasIdentity()) {
			$role = $this->_auth->getIdentity()->rol;/*ADMINISTRADOR*/
                       // $area=$this->_auth->getIdentity()->area;
					 
                        switch ($role)
                        {
                          case 'adminitrador':
                              Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/menu.ini')));     
                              break;
                          case 'administracion':
                              Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/menu_adm.ini')));     
                              break;
                          case 'voluntario':
                              Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/menu_volun.ini')));     
                              break;
                          case 'comercializacion':						      						  
                              //Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/m_comercializacion.ini')));     
                              break;
                          case 'produccion':
                              //Zend_Registry::set('Zend_Navigation', new Zend_Navigation(new Zend_Config_Ini(APPLICATION_PATH.'/admin/configs/m_produccion.ini')));     
                              break;
                          default :
                              
                        }
		} else {
			$role = 'invitado';
		}

		$controller = $request->controller;
		$action = $request->action;
		$module = $request->module;
		$resource="$module:$controller";

		if (!$this->_acl->has($resource)) {
			$resource = null;
		}

		if (!$this->_acl->isAllowed($role, $resource, $action)) 
		{
			if (!$this->_auth->hasIdentity()) {
				if($module=='default') {
					$module = self::USUARIO_NO_AUTH_MODULE;
					$controller = self::USUARIO_NO_AUTH_CONTROLLER;
					$action = self::USUARIO_NO_AUTH_ACTION;
				} 
				else {
					$module = self::NO_AUTH_MODULE;
					$controller = self::NO_AUTH_CONTROLLER;
					$action = self::NO_AUTH_ACTION;
				}
			}
			else 
			{
				if($module=='admin') 
				{
					$module = 'admin';
					$controller = 'index';
					$action = 'noautorizado';
				}
				else
				{
					$module = self::NO_ACL_MODULE;
					$controller = self::NO_ACL_CONTROLLER;
					$action = self::NO_ACL_ACTION;
				}
			}
		}



		$request->setModuleName($module);
		$request->setControllerName($controller);
		$request->setActionName($action);
	}
}