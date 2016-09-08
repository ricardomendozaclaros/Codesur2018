<?php
class Util_Cortartexto
{
	public static function cortar_texto($cadena, $longitud_maxima)
	{
		$cadena=strip_tags($cadena);
		$longitud = strlen($cadena );		
		if ($longitud > $longitud_maxima)
		{
			$pos_fin_palabra=strpos($cadena,' ',$longitud_maxima);
			if(!is_numeric($pos_fin_palabra))
				$pos_fin_palabra=$longitud;
			$nueva_cadena = substr ( $cadena, 0, $pos_fin_palabra );
			$nueva_cadena .= '...';
			return $nueva_cadena;
		} 
		else
		{
			return $cadena;
		}
	}
	
	public static function encontrar_id($cadena)
	{
		$pos_limitador = strpos($cadena,'-');
		if($pos_limitador>0)
		{
			$id = substr ($cadena, 0,$pos_limitador);
			return $id;
		}
		else 
			return $cadena;
		
		
		
	}
	
	public static function id($cadena)
	{
		$pos_limitador = strpos($cadena,'-');
		
		//$id = substr ($cadena,(int)($pos_limitador+1));
		$id = substr ($cadena,0,(int)($pos_limitador));
		return $id;
	}
	
	public static function limpiar($cadena) 
	{ 
		$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ";
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn_";
		$cadena_sin_acentos=strtr(utf8_decode($cadena),utf8_decode($tofind),utf8_decode($replac));
		
		/*para borrar todos los demas caracteres que no sean alfanumericos o _.*/
		$cadena = ereg_replace("[^a-zA-Z0-9_.]","",$cadena_sin_acentos);
		return $cadena;
	}
	
	public static function alias($cadena) 
	{ 
		$cadena=trim(html_entity_decode($cadena,ENT_QUOTES,'utf-8'));
		$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ ";
		$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn_";
		$cadena_sin_acentos=strtr(utf8_decode($cadena),utf8_decode($tofind),utf8_decode($replac));
		
		/*para borrar todos los demas caracteres que no sean alfanumericos o _.*/
		$cadena = ereg_replace("[^a-zA-Z0-9_.]","",$cadena_sin_acentos);
		$cadena = ereg_replace("[_]{2,}","_",$cadena);
		return strtolower($cadena);
		
		
		/*
		$tofind = "ÀÂÃÄÅàâãäåÒÔÕÖØòôõöøÈÊËèêëÇçÌÎÏìîïÙÛÜùûüÿ .";
		$replac = "AAAAAaaaaaOOOOOoooooEEEeeeCcIIIiiiUUUuuuy--";
		$cadena_sin_acentos=strtr(utf8_decode($cadena),utf8_decode($tofind),utf8_decode($replac));
		
		/*para borrar todos los demas caracteres que no sean alfanumericos o _.*/
		//$cadena = ereg_replace("[^a-zA-Z0-9-.]","",$cadena_sin_acentos);
		/*return $cadena_sin_acentos;
		*/
	}

	public static function acentos($cadena){
			$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿ";
			$replac = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuy";
			$cadena_sin_acentos=strtr(utf8_decode($cadena),utf8_decode($tofind),utf8_decode($replac));
			//$cadena_sin_acentos=strtr($cadena,$tofind,$replac);
			return utf8_encode($cadena_sin_acentos);
			//return $cadena_sin_acentos;
	}
	
	public static function buscarvideo($cadena)
	{
		$cadena=stripslashes($cadena);
		$cadenas_encontradas='';
		eregi('value=\"(.[^\"]*)\"',$cadena,$cadenas_encontradas);
		return $cadenas_encontradas[1];		
	}
	
	public static function encontrar_pagina($cadena)
	{
		$cadenas_encontradas='';
		eregi('(pagina|page)([1234567890]+)',$cadena,$cadenas_encontradas);
		return $cadenas_encontradas[2];		
	}
	
	public static function filtrar($cadena)
	{
		$allowedTags = array('a','strong','em','sup','sub','ol','ul','li','img','br','p');
		$allowedAttributes = array('href');            	
		$filtro=new Zend_Filter_StripTags($allowedTags,$allowedAttributes);
		$cadena_filtrada=$filtro->filter($cadena);
		unset($filtro);
		return $cadena_filtrada;		
	}
	
	public static function espacios($cadena)
	{
    $limpia    = "";
    $parts    = array();
    
    
    $parts = split(" ",$cadena);
    
    foreach($parts as $subcadena)
    {

        $subcadena = trim($subcadena);
        if($subcadena!="")
        { $limpia .= $subcadena." "; }
    }
    $limpia = trim($limpia);
    
    return $limpia;
	} 

	public static function pais($ip)
	{
		$resp = @file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ip&output=raw");
		
	
		//Use backup server if cannot make a connection
		if (!$resp){
			$backup = @file_get_contents("http://backup.ipinfodb.com/ip_query.php?ip=$ip&output=raw");
			$answer = explode(',',$backup);
			if (!$backup) return false; // Failed to open connection
		}else{
			$answer = explode(',',$resp);
		}
	
		$country_code = $answer['2'];
		$country_name = $answer['3'];
		$region_name = $answer['5'];
		$city = $answer['6'];
		$zippostalcode = $answer['7'];
		$latitude = $answer['8'];
		$longitude = $answer['9'];
		$timezone = $answer['10'];
		$gmtoffset = $answer['11'];
		$dstoffset = $answer['12'];
	
		//Return the data as an array
		return array('ip' => $ip, 'country_code' => $country_code, 'country_name' => $country_name, 'region_name' => $region_name, 'city' => $city, 'zippostalcode' => $zippostalcode, 'latitude' => $latitude, 'longitude' => $longitude, 'timezone' => $timezone, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
	}
	
	function locateIp2($ip)
	{
		$resp = @file_get_contents("http://www.ipinfodb.com/ip_query.php?ip=$ip&output=raw");
		
	
		//Use backup server if cannot make a connection
		if (!$resp){
			$backup = @file_get_contents("http://backup.ipinfodb.com/ip_query.php?ip=$ip&output=raw");
			$answer = explode(',',$backup);
			if (!$backup) return false; // Failed to open connection
		}else{
			$answer = explode(',',$resp);
		}
	
		$country_code = $answer['2'];
		$country_name = $answer['3'];
		$region_name = $answer['5'];
		$city = $answer['6'];
		$zippostalcode = $answer['7'];
		$latitude = $answer['8'];
		$longitude = $answer['9'];
		$timezone = $answer['10'];
		$gmtoffset = $answer['11'];
		$dstoffset = $answer['12'];
	
		//Return the data as an array
		return array('ip' => $ip, 'country_code' => $country_code, 'country_name' => $country_name, 'region_name' => $region_name, 'city' => $city, 'zippostalcode' => $zippostalcode, 'latitude' => $latitude, 'longitude' => $longitude, 'timezone' => $timezone, 'gmtoffset' => $gmtoffset, 'dstoffset' => $dstoffset);
	}
}
?>