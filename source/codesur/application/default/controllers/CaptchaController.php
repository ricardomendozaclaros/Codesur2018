<?php
class CaptchaController extends Zend_Controller_Action {

	public function init() {

		$this->_helper->layout->disableLayout(true);
		$this->_helper->viewRenderer->setNoRender(true);
		
		$this->view->id_seccion=$this->_request->getControllerName();
	}

	public function indexAction() {

		$code = $this->randString(5);

		$sesion_captcha=new Zend_Session_Namespace('captcha');
		$sesion_captcha->captcha=$code;

		$width = 100;
		$height = 25;

		$image = ImageCreate($width, $height);

		$fore = ImageColorAllocate($image, 59, 170, 227);
		$back = ImageColorAllocate($image, 230, 230, 230);

		ImageFill($image, 0, 0, $back);
		ImageString($image, 9, 30, 3, $code, $fore);

		$back = ImageColorAllocate($image, 0, 0, 0);
		//ImageLine ($image,0,10,100,20,$black);
		//ImageLine ($image,0,20,100,10,$black);

		header("Content-Type: image/png");
		ImagePng($image);

		ImageDestroy($image);

		ImageDestroy($image);
	}
	
	public function capAction()
	{				
		
		//include_once "Captcha/securimage.php";
		//Zend_Loader::loadClass('Util_Cortartexto');
		Zend_Loader::loadClass('Securimage');
		

		$img = new Securimage();		
		// Change some settings
		
		$img->image_width = 200;//275;
		$img->image_height = 64;//90;
		$img->perturbation =(float)(rand(6,8)/10); // 1.0 = high distortion, higher numbers = more distortion
		//$img->image_bg_color = new Securimage_Color("#0099CC");
		$img->text_color = new Securimage_Color("#0087a9");
		//$img->text_transparency_percentage = 65; // 100 = completely transparent
		$img->num_lines = (int)rand(3,5);
		$img->line_color = new Securimage_Color("#0087a9");
		//$img->signature_color = new Securimage_Color(rand(0, 64), rand(64, 128), rand(128, 255));
		$img->image_type = SI_IMAGE_PNG;
		
		//var_dump($img);exit();
		//$img->show();
		 
		// alternate use:
		$back=(int)rand(1,2);
		if($back==1)
			$background='backgrounds/bg4.jpg';
		elseif($back==2)
			$background='backgrounds/bg3.jpg';
		  
		$img->show($background);
		
	}

	private function randString($length) {
		$str = '';
		$dic = '0123456789abcdfghjkmnpqrstvwxyz';
		for($i = 0; $i < $length; $i++) {
			$char = substr($dic, mt_rand(0, strlen($dic)-1), 1);
			$str .= $char;
		}
		return $str;
	}
}
