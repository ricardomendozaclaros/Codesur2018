<?php

class ErrorController extends Zend_Controller_Action
{
	public function init()
	{
		
			$this->idioma=DEFAULT_IDIOMA;
			
			

		
		$this->view->idioma=$this->idioma;
		$this->view->layout()->disableLayout();
		
	}	

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

switch ($errors->type) { 
    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

        // 404 error -- controller or action not found
        $this->getResponse()->setHttpResponseCode(404);
        $this->view->message = 'Page not found';
        break;
    default:
        // application error 
        $this->getResponse()->setHttpResponseCode(500);
        $this->view->message = 'Application error';
        break;
}

$this->view->exception = $errors->exception;
$this->view->request   = $errors->request;
    }

	public function loginAction() 
	{
		$this->view->contenido = "Se tiene indentidad pero no tiene permiso para ver este recurso";
	}
	public function noticiaAction() 
	{
		$this->view->contenido = "Error, Noticia Inexistente";
	}
	
	public function paginaAction() 
	{
		$this->view->contenido = "Error, Página Inexistente";
		$this->render('login');
	}
	public function inexistenteAction() 
	{
		$this->render('login');
	}

}

