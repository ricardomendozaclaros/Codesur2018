<?php
class Admin_Form_Noticia_Noticia extends Zend_Form {
	public function init() {
		$this->setAttrib('id','form_admin');
	
		$this->setElementDecorators(array('ViewHelper',array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))));
		$this->addElementPrefixPath('Z_Filter', 'Z/Filter/', 'filter');
		$this->addElementPrefixPath('Z_Validate', 'Z/Validate/', 'validate');	
		
		$this->addElement('hidden','not_id');
		$this->addElement('hidden','not_pos',array('value'=>''));

		$this->addElement('text','not_orden',array(
			'label'      => 'Orden',
			'size'		=> '10',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','Int')				
		));
		
		
		$this->addElement('select','not_pos',array(
			'label'      => 'Posición',
			'multioptions'=>array(''=>'Selecciona una Opción',4=>'Rotador',1=>'Noticia Principal',2=>'Noticia comun',3=>'Noticia variado'),
			'required'   => true,	
                        'value'=>1
		));
		
		$this->addElement('select','not_pos_img',array(
			'label'      => 'Posición Imagen',
			'multioptions'=>array(''=>'Selecciona una Opción',0=>'Arriba',1=>'Abajo',2=>'Izquierda',3=>'Derecha'),
			'required'   => true,
                    'value'=>2
		));
		$valida_unico_es=new Z_Validate_Unique('noticia','not_titulo_es',$this->not_id);
		$this->addElement('text','not_titulo_es',array(
			'label'      => 'Título (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_es)					
		));
		
		$valida_unico_en=new Z_Validate_Unique('noticia','not_titulo_en',$this->not_id);
		$this->addElement('text','not_titulo_en',array(
			'label'      => 'Título (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unico_en)				
		));
                
                $valida_unic_es=new Z_Validate_Unique('noticia','not_antetitulo_es',$this->not_id);
		$this->addElement('text','not_antetitulo_es',array(
			'label'      => 'Ante Título (ES)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_unic_es)					
		));
		
		$valida_uni_en=new Z_Validate_Unique('noticia','not_antetitulo_en',$this->not_id);
		$this->addElement('text','not_antetitulo_en',array(
			'label'      => 'Ante Título (EN)',
			'size'		=> '60',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes'),
			'validators'=>array($valida_uni_en)				
		));
		
//		$this->addElement('textarea','not_entradilla_es',array(
//			'label'      => 'Entradilla (ES)',
//			'rows'		=> '15',
//			'cols'		=> '70',
//			'class'		=> 'tinymce',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
//		));	
//		
//		$this->addElement('textarea','not_entradilla_en',array(
//			'label'      => 'Entradilla (EN)',
//			'rows'		=> '15',
//			'cols'		=> '70',
//			'class'		=> 'tinymce',
//			'required'   => true,
//			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
//		));	
		
		
		
		$this->addElement('textarea','not_cuerpo_es',array(
			'label'      => 'Cuerpo (ES)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		$this->addElement('textarea','not_cuerpo_en',array(
			'label'      => 'Cuerpo (EN)',
			'rows'		=> '15',
			'cols'		=> '70',
			'class'		=> 'tinymce',
			'required'   => true,
			'filters'	=>array('StringTrim','StripSlashes','SafeTags')			
		));	
		
		
		
		$this->addElement('file','not_img',array(
			'label'			=> 'Imagen (jpg,png,gif)(750x400)',
			'required'		=>	true
		));
		
		$this->not_img->setRequired(false)
			->setDecorators(array('File', array('ViewScript', array('viewScript' => 'decoradorsoloerror.phtml', 'placement' => FALSE))))
			->addValidator('Count', false, array(1,'messages'=>'Debe subir una imagen'))
			->addValidator('Size', false, array('max'=>'2097152','messages'=>'El tama&ntilde;o maximo aceptado 2MB'))
			->addValidator('Extension', false, array('jpg,jpeg,png,gif','messages'=>'El archivo debe ser una imagen'));
		
		$this->addElement('radio','not_estado',array(
			'label'      => 'Mostrar',
			//'required'   => true,
			'multioptions' =>array(1=>'Mostrar ',0=>'NO mostrar'),					
			//'validators' => array('NotEmpty'),
			'value'=>1
		));	
		$this->addElement('submit','Guardar');
		
	}
}
	
?>