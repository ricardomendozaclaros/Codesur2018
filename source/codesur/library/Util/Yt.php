<?php
class Util_Yt
{
	public static function buscarvideo2($cadena)
	{
		$cadena=stripslashes($cadena);
		$cadenas_encontradas='';
		eregi('value=\"(.[^\"]*)\"',$cadena,$cadenas_encontradas);
		if($cadenas_encontradas[1])
			return $cadenas_encontradas[1];	
		else
		{
			$_id = parse_url($cadena);
			parse_str($_id['query']);
			unset($_id);
			$id = empty($v) ? $cadena : $v;
			return "http://www.youtube.com/v/".$id;
		}
	}
	public static function buscarvideo($cadena)
	{
		$cadena=stripslashes($cadena);
		$cadenas_encontradas='';//var_dump($cadena);exit();
		eregi('youtube.com\/v\/([^&]*)&',$cadena,$cadenas_encontradas);
		
		
		if($cadenas_encontradas[1])
			return $cadenas_encontradas[1];	
		else
		{
			$_id = parse_url($cadena);
			parse_str($_id['query']);
			unset($_id);
			$id = empty($v) ? $cadena : $v;
			return $id;
		}
	}

//      public static function get_thumbnail($video_url, $quality = 'default')
//{
//	$video_id = get_youtube_id($video_url);
//	return 'http://img.youtube.com/vi/' . $video_id . '/' . $quality . '.jpg';
//
//
//
//        return $id;
//    }
}
?>