<?php
class Model_Marca_Marca extends Z_Admin_Table {
	protected $_name = 'marca';
	public $prefijo="mar_";
	
	public function add($data) {
		
		$id = $this->info('primary');
		$data[$id[1]] = null;		
		$data[$this->prefijo.'fecha_creacion'] = new Zend_Db_Expr('NOW()');
		
		
		$data[$this->prefijo.'alias_es']=Util_Cortartexto::alias($data[$this->prefijo.'nombre_es']);
		$data[$this->prefijo.'alias_en']=Util_Cortartexto::alias($data[$this->prefijo.'nombre_en']);
				
		return $this->createRow( $data )->save();
	}

	public function edit($data) {

		$id = $this->info('primary');
		$row = $this->find($data[$id[1]])->current();
		$data[$this->prefijo.'fecha_edicion'] = new Zend_Db_Expr('NOW()');
		
		if($data[$this->prefijo.'nombre_es'])
			$data[$this->prefijo.'alias_es']=Util_Cortartexto::alias($data[$this->prefijo.'nombre_es']);
			
		if($data[$this->prefijo.'nombre_en'])
			$data[$this->prefijo.'alias_en']=Util_Cortartexto::alias($data[$this->prefijo.'nombre_en']);
			
		$row->setFromArray( $data )->save();
	}	
	

	public function del($data) 
	{
		$this->find($data)->current()->delete();
		if($this->dependiente)
		{
			$db=Zend_Registry::get('db');
			$id = $this->info('primary');
			$id = $id[1];
			$db->delete($this->dependiente,$id."=".$data);
		}
	}
}
