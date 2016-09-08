<?php
class Form_Contacto_Voluntariado extends Zend_Form {

public function init() {
	
		$decoradores = array(  
          'ViewHelper',  
          array('ViewScript', array('viewScript' => 'decoradorvacio.phtml', 'placement' => FALSE)),  
     							);
     						
     	$this->setElementDecorators($decoradores);    	
     							
     	
		$this->addElement('text','vol_nombre',array(
			'label'			=> 'Nombre',
			'size'			=> 33,			
			'required'		=>true,
                  //  'required'		=>"required",
			'class' =>'form-control',
                         "id"=>"focusedInput"
		));		
		$this->addElement('text','vol_paterno',array(
			'label'			=> 'paterno',
			'size'			=> 33,			
			'required'		=>true,
			'class' =>'form-control', "id"=>"inputSeleccionado"
		));
		$this->addElement('text','vol_email',array(
			'label'			=> 'E-mail',
			'size'			=> 33,
			'validators'	=>array('emailAddress'),			
			'required'		=>true,
			'class' =>'form-control', "id"=>"inputSeleccionado"
		));
                $this->addElement('text','vol_telefono',array(
			'label'			=> 'E-mail',
			'size'			=> 33,
//			'validators'	=>array('emailAddress'),			
			'required'		=>true,
			'class' =>'form-control',
                    "id"=>"inputSeleccionado"
		));
                $this->addElement('text','vol_celular',array(
			'label'			=> 'E-mail',
			'size'			=> 33,
//			'validators'	=>array('emailAddress'),			
			'required'		=>true,
			'class' =>'form-control', "id"=>"inputSeleccionado"
		));
       // $db=Zend_Registry::get('db');
		//$voluntariado=$db->fetchPairs('SELECT vol_id,vol_titulo_es	FROM voluntariado_tipo 	where vol_estado=1	');	
		
	//	$this->addElement('select','vol_id',array(
			//'label'      => 'Producto',
	//		'required'   => true,			
	//		'multioptions'=>array(''=>'Selecciona una Opción')
	//	));
	//	$this->vol_id->addMultioptions($voluntariado);
	
		$this->addElement('textarea','vol_mensaje',array(
			'label'			=> 'Ingresa tu mensaje',
			'cols'			=> 30,			
			'rows'			=> 3,
			'required'		=>false,
			'class' =>' form-control', "id"=>"inputSeleccionado"
		));	
		
			
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes','SafeTags','Nl2br'));
	}
}