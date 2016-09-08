<?php
class Zend_View_Helper_MenuSecciones extends Zend_View_Helper_Abstract {

	function menuSecciones($tabla,$prefijo,$id=0,$nivel=0,$max_nivel=0)
	{	
		$q="SELECT ".$prefijo."id,".$prefijo."padre,".$prefijo."nombre 
			FROM $tabla 
			WHERE ".$prefijo."padre=? 
			ORDER BY ".$prefijo."orden DESC";
			
		$db=Zend_Registry::get('db');			
		$categorias=$db->fetchAll($q,array($id));
		$categorias_respuesta=array();		
		foreach ($categorias as $fila) 
		{
			$subcats=$this->subcats($tabla,$prefijo,$fila[$prefijo.'id']);			
			if($subcats&&$nivel<$max_nivel)
			{				
				$categorias_respuesta=array_merge($categorias_respuesta,$this->menuSecciones($tabla,$prefijo,$fila[$prefijo.'id'],$nivel+1,$max_nivel));									
			}
			else
			{
				$categorias_respuesta[]=$fila;	
			}		
		}	
		return $categorias_respuesta;
	}
	

	function subcats($tabla,$prefijo,$id)
	{		
		$db=Zend_Registry::get('db');
		$nrosubcategorias=$db->fetchOne("SELECT count(".$prefijo."id) FROM $tabla WHERE ".$prefijo."padre=?",$id);
		return (int)$nrosubcategorias;		
	}

}

