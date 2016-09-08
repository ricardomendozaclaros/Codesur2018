<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/

class Util_Image {

	var $image;
	var $image_type;

	function load($filename) {
		$image_info = getimagesize($filename);
		$this->image_type = $image_info[2];
		if( $this->image_type == IMAGETYPE_JPEG ) {
			$this->image = imagecreatefromjpeg($filename);
		} elseif( $this->image_type == IMAGETYPE_GIF ) {
			$this->image = imagecreatefromgif($filename);
		} elseif( $this->image_type == IMAGETYPE_PNG ) {
			$this->image = imagecreatefrompng($filename);
		}
	}
	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=CALIDAD_IMGS, $permissions=null) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image,$filename,$compression);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->image,$filename);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image,$filename);
		}
		if( $permissions != null) {
			chmod($filename,$permissions);
		}
	}
	function output($image_type=IMAGETYPE_JPEG) {
		if( $image_type == IMAGETYPE_JPEG ) {
			imagejpeg($this->image);
		} elseif( $image_type == IMAGETYPE_GIF ) {
			imagegif($this->image);
		} elseif( $image_type == IMAGETYPE_PNG ) {
			imagepng($this->image);
		}
	}
	function getWidth() {
		return imagesx($this->image);
	}
	function getHeight() {
		return imagesy($this->image);
	}
	function resizeToHeight($height) {
		$ratio = $height / $this->getHeight();
		$width = $this->getWidth() * $ratio;
		$this->resize($width,$height);
	}
	function resizeToWidth($width) {
		$ratio = $width / $this->getWidth();
		$height = $this->getheight() * $ratio;
		$this->resize($width,$height);
	}
	function scale($scale) {
		$width = $this->getWidth() * $scale/100;
		$height = $this->getheight() * $scale/100;
		$this->resize($width,$height);
	}
	function resize($width,$height) {
		$new_image = imagecreatetruecolor($width, $height);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
		$this->image = $new_image;
	}

	public function resize2( $size ) {//static 

		$width = $this->getWidth();
		$height = $this->getHeight();

		if( $width <= $size && $height <= $size ) { return true; }

		$percent = $size/max($width, $height);
		$width2 = round($width * $percent);
		$height2 = round($height * $percent);

		$new_image = imagecreatetruecolor($width2, $height2);
		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width2, $height2, $width, $height);
		$this->image = $new_image;
	}
	
	public static function resize3( $file, $size ) {

		if( is_null($size) )
			$size = 377;

		list($width, $height) = getimagesize($file);

		if( $width <= $size && $height <= $size ) { return true; }

		$percent = $size/max($width, $height);
		$width2 = round($width * $percent);
		$height2 = round($height * $percent);

		$image = imagecreatetruecolor($width2, $height2);
		$original = imagecreatefromjpeg($file);
		imagecopyresampled($image, $original, 0, 0, 0, 0, $width2, $height2, $width, $height);

		imagejpeg($image,$file,100);

		imagedestroy($image);
		imagedestroy($original);

		return true;
	}
	
	public function redimensionar($datos) 
	{ 
		$width = $this->getWidth();
		$height = $this->getHeight();
		
		
		
		if($datos['width']&&!$datos['height']&&$datos['width']<$width)		
			$this->resizeToWidth($datos['width']);
		elseif($datos['height']&&!$datos['width']&&$datos['height']<$height)
			$this->resizeToHeight($datos['height']);
		elseif ($datos['width']&&$datos['height']&&($datos['width']<$width||$datos['height']<$height))
		{
			
			if($width<$datos['width']&&$height>$datos['height'])//img org mas alta que el parametro, pero menos ancha
			{
				$this->resizeToHeight($datos['height']);				
			}
			if($width>$datos['width']&&$height<$datos['height'])//img org mas ancha que el parametro, pero menos alta
			{
				$this->resizeToWidth($datos['width']);				
			}
			if($width>$datos['width']&&$height>$datos['height'])//si es mas alta y mas ancha
			{
				$ratio = $datos['height']/$height;
				$width_red = $this->getWidth() * $ratio;				
			
				$ratio = $datos['width']/$width;
				$height_red = $this->getheight() * $ratio;			
				
				if($datos['width']<$width_red)
					$this->resizeToWidth($datos['width']);
				elseif ($datos['height']<$height_red)				
					$this->resizeToHeight($datos['height']);
				else
					$this->resize2($datos['width']);
			}
		}
		else 
			$this->resize2($datos);
		
		return true;		
	}
}