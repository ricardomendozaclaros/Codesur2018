<?php
class Util_Imagen
{
	public function redimensionar_imagen($nombre_imagen,$tamano)
	{
		if(is_null($tamano))
			$tamano=TAMANO_IMG;		
			
		//$tamano=200;// tamaño maximo de la imagen ancho y alto
		
		// Se obtienen las dimensiones de la imagen original
						
		list($ancho, $alto) = getimagesize("./imgs_subidas/".$nombre_imagen);//list es para obtener en las variables los valores de un arreglo
		
		if($ancho<=$tamano&&$alto<=$tamano){return true;} //si la imagen es menor igual al tamaño reuqerido no se hace nada
		
		//se calcula el porcentaje para reducir la imagen
		$percent = $tamano/max($ancho,$alto);
		$nuevo_ancho = round($ancho * $percent);
		$nuevo_alto = round($alto * $percent);
		
		
		$imagen = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);//se crea una imagen en blanco
		$imagen_original = imagecreatefromjpeg("./imgs_subidas/".$nombre_imagen);//se carga la imagen original a partir de jpg(mejorar para todo tipo)
		
		// Redimensionar
		//imagecopyresized($imagen, $imagen_original, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);//(se pierde calidad)
		imagecopyresampled($imagen, $imagen_original, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);//no se pierde calidad
		
		
		imagejpeg($imagen,'./imgs_subidas/'.$nombre_imagen,CALIDAD_IMG);//guardar al disco la imagen, 100 es la calidad, por defecto 75
		//header("Content-Type: image/jpeg"); 
		//imagejpeg($imagen);//para mostrar la imagen
		imagedestroy($imagen);//se libera memoria
		imagedestroy($imagen_original);
		return true;
	}
}