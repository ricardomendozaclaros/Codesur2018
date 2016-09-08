<?php
class Util_Mail {

	protected $transporte=null;
	public function __construct($transp=null)
	{
		if($transp)
		{
			$this->transporte=$transp;
		}
		else 
		{
			$this->transporte= Zend_Mail::getDefaultTransport();	
		}		
	}
	
	/**
     * Envia un mail a los destinatarios seleccionados
     *
     * @param mixed $cuerpo Cuerpo del mensaje
     * @param string $de mail de quien envia el mail
     * @param string $nombre_de nombre de quien envia el mail
     * @param array $para Los que recibiran el mensaje array(email=>nombre)    
     * @param string $asunto Asunto del mail
     * @return boolean  true si se realizo en envio false en otro caso
     */
	public function enviar($cuerpo,$de,$nombre_de,$para,$asunto)
	{
		try {
		$mail = new Zend_Mail('utf-8');
		$mail->setBodyText(strip_tags($cuerpo),'utf-8');
		$mail->setBodyHtml($cuerpo,'utf-8');
		$mail->setFrom($de, $nombre_de);
		foreach ($para as $email=>$nombre) 
		{
			$mail->addTo($email, $nombre);
		}	
		
		$mail->setSubject($asunto);
		$mail->send($this->transporte);
		return true;
		}
		catch (Exception $e)
		{
			//echo $e;exit();
			return false;
		}
	}
	
}