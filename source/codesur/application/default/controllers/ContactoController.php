<?php
class ContactoController extends Zend_Controller_Action
{
	
	public function init()
	{
		$this->view->controlador=$this->_request->getControllerName();
						
		if($this->_request->getParam('idioma'))
			$this->idioma=$this->_request->getParam('idioma');
		else			
			$this->idioma=DEFAULT_IDIOMA;
			
		$locale=Zend_Registry::get('Zend_Locale');
		$trans=Zend_Registry::get('Zend_Translate');
		$locale->setLocale($this->idioma);
		$trans->setLocale($locale);	
		$this->view->idioma=$this->idioma;
		$this->view->headMeta()->appendName('language', $this->idioma);
		
		$this->numero_registros=2;
		$this->rango_paginas=10;	
		
		$this->view->headTitle($this->view->translate("Contactos"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Contactos"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Contactos"),'keywords');
	}	
	
	public function indexAction()
	{
		$db=Zend_Registry::get('db');
		$this->view->contacto=$db->fetchRow("SELECT * FROM datos_contacto WHERE con_id=1");
		
		$form=new Form_Contacto_Contacto();
		$this->view->form=$form;		
		
		if($this->_request->isPost())
		{	
			$datos=$this->_request->getParams();
						
			if($form->isValid($datos))
			{
				$datos=$form->getValues();
				$db=new Model_Contacto_Contacto();
				$datos["con_idioma"]=$this->idioma;
				$db->add($datos);
				$this->enviar_mail($datos);
				$this->_redirect("/".$this->idioma."/contacto/ok/");				
			}
			else {
				/* aqui poner mensaje no valido*/				
			}
		}
		else 
		{
			if($this->_request->getParam('enviado')=='ok')
				$this->view->mensaje="Sus datos fueron enviados con exito.";			
		}
	}
	
	
	function enviar_mail($datos)
	{
//		$email=$datos['con_email'];	
//		$db=Zend_Registry::get('db');
//		$fila_contacto=$db->fetchRow("Select * from datos_contacto WHERE con_id=1");		
//		$emails_destino=explode(",",$fila_contacto['con_email']);
//		
//		$email_destino=array();
//		foreach ($emails_destino as $e_mail)		
//			$email_destino[$e_mail]=$e_mail;
//		$html="
//		<table>
//				
//		<tr>
//		<td>Nombre: </td><td>".$datos['con_nombre']."</td>
//		</tr>
//		<tr>
//		<td>E-mail: </td><td>".$datos['con_email']."</td>
//		</tr>
//		<tr>
//		<td>Mensaje: </td><td>".$datos['con_mensaje']."</td>
//		</tr>
//		</table>
//		";
//		
//		$mail=new Util_Mail();
//		$mail->enviar($html,$email,$email,$email_destino,"Contacto ".NOMBRE_SITIO." de ".$email);
                
                
                
                $nombre=$datos['con_nombre'];
                 $email=$datos['con_email'];	

            $headers = "From: $nombre <$email>\r\n"; //Quien envia?
            $headers .= "X-Mailer: PHP5\n";
            $headers .= 'MIME-Version: 1.0' . "\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; //
             $email_contacto="info@cochabamba2018.bo";
            $subject="";
            $html="
		<table>
				
		<tr>
		<td>Nombre: </td><td>".$datos['con_nombre']."</td>
		</tr>
		<tr>
		<td>E-mail: </td><td>".$datos['con_email']."</td>
		</tr>
		<tr>
		<td>Mensaje: </td><td>".$datos['con_mensaje']."</td>
		</tr>
		</table>
		";
// <tr>
//            <td>Pais: </td><td>".$pais."</td>
//            </tr>
            mail($email_contacto, $subject, $html,    $headers);
	}
	
	
}
?>