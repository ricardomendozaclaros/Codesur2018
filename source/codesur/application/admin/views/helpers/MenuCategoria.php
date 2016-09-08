<?php
class Zend_View_Helper_MenuCategoria extends Zend_View_Helper_Abstract {

	function menuCategoria($tabla,$prefijo)
	{	
		$q="SELECT ".$prefijo."id,".$prefijo."nombre 
			FROM $tabla			 
			ORDER BY ".$prefijo."orden DESC";
			
		$db=Zend_Registry::get('db');			
		$categorias=$db->fetchAll($q);
		$categorias_respuesta=array();		
		foreach ($categorias as $fila) 
		{			
				$categorias_respuesta[]=$fila;					
		}	
		return $categorias_respuesta;
	}
}

