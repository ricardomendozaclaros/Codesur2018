<?php
class Admin_Form_Usuario_Usuario extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
		
		
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');
		$this->addElement('hidden','usu_id');		
				
				
		$this->addElement('hidden','usu_codigo_activacion',array('value'=>substr(sha1(microtime()),0,10)));
		
		$this->addElement('text','usu_nombre',array(
			'label'      => 'Nombre',
			'size'		=> '22',		   
			'required'   => true,
			'class'		=>'input_form_reg'		
		));
		
		
		$this->addElement('text','usu_apellido',array(
			'label'      => 'Apellido',
			'size'		=> '22',		   
			'required'   => true,
			'class'		=>'input_form_reg'		
		));		

		$unico_mail=new Z_Validate_Unique('usuario','usu_email',$this->usu_id);
		$this->addElement('text','usu_email',array(
			'label'      => 'Correo electrónico',
			'size'		=> '22',
			'required'   => true,
			'validators' => array('EmailAddress',$unico_mail),
			'class'		=>'input_form_reg'
		));
		
		
		
		$this->addElement('text','usu_pass',array(
			'label'      => 'Contraseña',
			'size'		=> '22',
			'required'   => true,
			'class'		=>'input_form_reg'
						
		));
		$this->usu_pass->addValidator('stringLength', false, array(5, 20));
		
		
		
		
		$this->addElement('textarea','usu_direccion',array(
			'label'      => 'Dirección',
			'cols'		=> '35',
		    'rows'		=> '3',
			'required'   => false,
			'class'		=>'input_form_reg'			
		));
		
		
		
		$db=Zend_Registry::get("db");
		$consulta="
				SELECT	pai_id,pai_nombre
				FROM paises
				ORDER BY pai_nombre 						
				";
		$paises=$db->fetchPairs($consulta);
		
		$this->addElement('select','pai_id',array(
			'label'      => 'País',		
			'multioptions'=>array(""=>"Seleccione una opcion"),
			'required'   => true,
			//'validators' => array('NotEmpty'),
			'class'		=>'select_form_reg'			
		));
		$this->pai_id->addMultiOptions($paises);
		
		
		
		$this->addElement('text','usu_ciudad',array(
			'label'      => 'Ciudad',
			'size'		=> '22',
			'required'   => false,
			'class'		=>'input_form_reg'			
		));
		
		$this->addElement('text','usu_telefono',array(
			'label'      => 'Telefono',
			'size'		=> '22',
			'required'   => true,
			'class'		=>'input_form_reg'			
		));
								
		
		$this->addElement('submit','Enviar');

		
				
		
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');		
		$this->setElementFilters(array('StringTrim','StripSlashes'));
	}
}
	