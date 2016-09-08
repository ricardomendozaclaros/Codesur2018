<?php
class Admin_VoluntariadoController extends Z_Admin_Controller {

	public function _init() {

		$this->url  = '/admin/voluntariado';
		$this->data = new Model_Contacto_Voluntariodatos();		
		$this->form = new Admin_Form_Contacto_Voluntariadotipo();		
		$this->upload  = '/admin/voluntariado';
		$this->view->title = 'Voluntariado';
		$this->numero_registros=20;
		$this->rango_paginas=20;		
		$this->view->hidden=array('id',"editar","marcar");
		
		$this->view->no_nuevo=false;
		
	}
	
	
	
	public function _listar() {
		
        $db = Zend_Registry::get ( 'db' );
        $miarray = array();
        $lis ="select v.*,(vol_id) as id, vp.pai_nombre
from voluntariado v
join  voluntario_paises vp 
where vp.pai_id=v.pai_id";
        $lis=$db->fetchAll($lis);
        foreach ($lis as $l){
            $product_ids=$l["vol_preferencias"];
            $id=$l["id"];
            $select = $db->select ()
                        ->from (array('v'=>"vountariado_tipo"),array("Preferencia"=>"v.vol_titulo_es"))
                        ->where('v.vol_id IN (?)', $product_ids);
           
        $select=$db->fetchRow($select);    
        $select["id"]=$id;
        $select["Nombre"]=$l["vol_nombre"]." ".$l["vol_paterno"];
        $select["Telefono"]=$l["vol_telefono"];
        $select["Celular"]=$l["vol_celular"];
        $select["Pais"]=$l["pai_nombre"];
        $select["Email"]=$l["vol_email"];
         $select["Emensaje"]=$l["vol_mensaje"];
        array_push($miarray,$select);
        }
      $respuesta=$miarray;  
      
        
//                $select = $db->select ()
//                        ->from (array('v'=>$this->data->info('name')))
//                        ->join (array("vt"=>"vountariado_tipo"),"v.vol_area_operativa=vt.vol_id")
//                        
//                        ->where('v.vol_preferencias IN (?)', $product_ids);
//        $select = $db->select ()
//        ->from (array('c'=>$this->data->info('name')),
//        array('id'=>'vol_id',   
//               //'Idioma'=>new Zend_Db_Expr("CASE vol_idioma WHEN en THEN 'En' WHEN es THEN 'Es' ELSE 'Error' END"),
//               'Nombre'=>'vol_nombre',
//               'Apellidos'=>'vol_paterno',
//               'A. Operativa'=>new Zend_Db_Expr("CASE vol_area_perativa WHEN 1 THEN 'Protocolo' "
//                       . " WHEN 2 THEN 'Com. Marketing'"
//                       . " WHEN 3 THEN 'Salud' "
//                       . " WHEN 4 THEN 'Tec. deportiva' "
//                       . " WHEN 5 THEN 'Transporte'"
//                       . " WHEN 6 THEN 'Hospedaje Alimen.'"
//                       . " WHEN 7 THEN 'Escenario Dep'"
//                       . " WHEN 8 THEN 'Tecnologia'"
//                       . " WHEN 9 THEN 'Ser. Com.Olim Nac'"
//                       . " WHEN 10 THEN 'Villa Suramericana'"
//                       . " WHEN 11 THEN 'Sub Villa Tropico'"
//                       . "ELSE 'Error' END"),
//            'Form Prof.'=>new Zend_Db_Expr("CASE vol_formacion_profecional WHEN 1 THEN 'Estudiante' "
//                       . " WHEN 2 THEN 'Universitario'"
//                       . " WHEN 3 THEN 'Profecional' "
//                       . " WHEN 4 THEN 'Tecnico' "
//                       . " WHEN 5 THEN 'Otros' "
//                       . "ELSE 'Error' END"),
//               'Telefono'=>'vol_telefono',
//               'Mobil'=>'vol_celular',
//               'Email Contacto'=>'vol_email',         	   
//               'Tema'=>'vol_mensaje',
//              // 'Fecha'=>'vol_fecha_creacion'
//        ))
//        //->order("vol_fecha_creacion desc")                 
//        ;
         
		return $respuesta;		
	}
}