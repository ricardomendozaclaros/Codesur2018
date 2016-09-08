<?php
class VoluntariadoController extends Zend_Controller_Action
{
	
	public function init()
	{
		$this->view->controlador=$this->_request->getControllerName();
						
		if($this->_request->getParam('idioma'))
			$this->idioma=$this->_request->getParam('idioma');
		else			
			$this->idioma=DEFAULT_IDIOMA;
			
		$locale=Zend_Registry::get('Zend_Locale');
		$trans=Zend_Registry::get('Zend_Translate');
		$locale->setLocale($this->idioma);
		$trans->setLocale($locale);	
		$this->view->idioma=$this->idioma;
		$this->view->headMeta()->appendName('language', $this->idioma);
		
		$this->numero_registros=2;
		$this->rango_paginas=10;	
		
		$this->view->headTitle($this->view->translate("Voluntariados"),"APPEND");
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Voluntariados"),'description');
		$this->view->headMeta(NOMBRE_SITIO." ".$this->view->translate("Voluntariados"),'keywords');
	}	
	
	public function indexAction()
	{
		$db=Zend_Registry::get('db');
//		$this->view->contacto=$db->fetchRow("SELECT * FROM datos_contacto WHERE con_id=1");
		
                $preguntas="select * from voluntariado_preguntas_frecuentes where pre_estado=1";
                $preguntas=$db->fetchAll($preguntas);
                $this->view->preguntas=$preguntas;
				
                $f="Select * from voluntariado_preguntas_frecuentes WHERE pre_id=0";
                $f=$db->fetchRow($f);

                 $vol="Select * from vountariado_tipo WHERE vol_estado=1";
                $vol=$db->fetchAll($vol);
                  $this->view->vol=$vol;
                  
                 $ben="Select * from voluntariado_beneficios WHERE ben_estado=1";
                $ben=$db->fetchAll($ben);
                $this->view->ben=$ben;
                $this->view->que_es= $f["pre_descripcion_".$this->idioma];

	}
        public function contactosAction(){
            $form=new Form_Contacto_Voluntariado();
           $this->view->mensaje="";
           $this->view->form=$form;
           $this->view->nombre="";
           $this->view->ok=0;
           $db=Zend_Registry::get('db');
                if($this->_request->isPost())
		{	
			$datos=$this->_request->getParams();
			$operativa=$datos["vol_area_perativa"];
			$formacion=$datos["vol_formacion_profecional"];
                        $area=$datos["vol_area_perativa"];    
                        $aa="";
                        foreach ($area as $a){
                               $aa.= $a.",";
                        }
                         $aa=  trim($aa,",");
                        
                        $id_pais=$datos["pai_id"];
                        $paises='SELECT * FROM voluntario_paises where pai_id='.$id_pais;
                     
                        $p=$db->fetchRow($paises);
			if($form->isValid($datos))
			{
				$datos=$form->getValues();
				
                                
				$db=new Model_Contacto_Voluntariodatos();
				$datos["vol_idioma"]=$this->idioma;
				$datos["vol_area_perativa"]=$operativa;
				$datos["vol_formacion_profecional"]=$formacion;
                                $datos["vol_pais"]=$p["pai_nombre"];
                                $datos["pai_id"]=$id_pais;
                                $datos["vol_preferencias"]=$aa;
                                $datos["vol_area_perativa"]=serialize($datos["vol_area_perativa"]);
				$db->add($datos);
                                 $this->view->ok=1;
                                 $this->view->nombre=ucfirst(strtolower($datos["vol_nombre"]))." ".ucfirst(strtolower($datos["vol_paterno"]));
                                 $this->enviar_mail($datos);
                                 $form->reset();
				//$this->_redirect("/".$this->idioma."/contactos_voluntariado/ok");
			}
			else {
				/* aqui poner mensaje no valido*/				
			}
		}
		else 
		{
			if($this->_request->getParam('enviado')=='ok'){
				$this->view->mensaje=$this->view->translate("sus datos fueron enviados con exito");			
                                 $this->view->ok=1;
                        }
		}
        }
                
	function enviar_mail($datos)
	{
		$nombre=$datos['vol_nombre'];
                 $email=$datos['vol_email'];	
		$db=Zend_Registry::get('db');
		 $id_area=  explode(",",$datos['vol_preferencias']);
                 $pref="";
                 foreach ($id_area as $p){
                    $area="select * from vountariado_tipo where vol_id=$p";
                    $area=$db->fetchRow($area);
                    $pref.=$area["vol_titulo_es"].",";
                 }
                     $area_operativa=  trim($pref,",");
                 
                $id_pais=$datos["pai_id"];
                $pais="select * from voluntario_paises where pai_id=$id_pais";
                $pais=$db->fetchRow($pais);
                $nombre_pais=$pais["pai_nombre"];
                switch ($datos["vol_formacion_profecional"]) {
                    case 1: $formacion_prof="Estudiante";   break;
                    case 2: $formacion_prof="Univercitario";   break;
                    case 3: $formacion_prof="Profecional";   break;
                    case 4: $formacion_prof="Tecnico";   break;

                    default:
                        break;
                }
                
		//$area_operativa=$area["vol_titulo_es"];
            $headers = "From: $nombre <$email>\r\n"; //Quien envia?
            $headers .= "X-Mailer: PHP5\n";
            $headers .= 'MIME-Version: 1.0' . "\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; //
             $email_contacto="voluntariado@cochabamba2018.bo";
            $subject="";
            $html="
            <table>
            <tr>
            <td>Nombre: </td><td>".$datos['vol_nombre']."</td>
            </tr>
            <tr>
            <td>Area Operativa: </td><td>".$area_operativa."</td>
            </tr>
            
            <tr>
            <td>Formacion Profecional: </td><td>".$formacion_prof."</td>
            </tr>
           <tr>
            <td>Pais: </td><td>".$nombre_pais."</td>
            </tr>
            
            <tr>
            <td>E-mail: </td><td>".$datos['vol_email']."</td>
            </tr>
            <tr>
            <td>Telefono: </td><td>".$datos['vol_telefono']."</td>
            </tr>
            <tr>
            <td>Celular: </td><td>".$datos['vol_celular']."</td>
            </tr>
            <tr>
            <td>Mensaje: </td><td>".$datos['vol_mensaje']."</td>
            </tr>
            </table>
            ";
// <tr>
//            <td>Pais: </td><td>".$pais."</td>
//            </tr>
            mail($email_contacto, $subject, $html,    $headers);
	}
	
	public function detalleAction()
	 	{
                 $id=$this->_request->getParam("dato");
                
	 	 $this->_helper->layout->disableLayout();
	        $this->_helper->viewRenderer->setNoRender();
                 $sw=false;$dato="";
                $db=Zend_Registry::get('db');
                 $vol="Select * from voluntariado_tipo WHERE vol_id=1";
                $vol=$db->fetchRow($vol);
                
                $f="Select * from voluntariado_preguntas_frecuentes WHERE pre_id=0";
                $f=$db->fetchRow($f);
    
                if($id){
                $fila="Select * from vountariado_tipo WHERE vol_id=$id";
                $fila=$db->fetchRow($fila);
                $sw=true; 
                $dato= $fila["vol_descripcion_".$this->idioma];
                         }else{
                        $dato=$f["pre_descripcion_".$this->idioma]; $sw=true;   
                         }
                echo  json_encode(array('ok'   => $sw,'html' => $dato
               ));
                
                }
                public function documentoAction() {
                $db=Zend_Registry::get('db');
                $nombre=$this->_request->getParam("pdf_alias");
                $pdf="select * from voluntariado_pdf where pdf_alias_$this->idioma='$nombre'"; 

                $pdf=$db->fetchRow($pdf);
                $this->view->pdf=$pdf;
                }
}
?>