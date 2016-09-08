<?php
class Util_Visitas
{
	public static function total()
	{
		$db=Zend_Registry::get('db');
		return (int)$db->fetchOne("SELECT SUM(vis_visitas) FROM visita");
	}	
}
?>