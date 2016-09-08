<?php
class Z_Admin_Table extends Zend_Db_Table {
	public function add($data) {
		
		$id = $this->info('primary');
		$data[$id[1]] = null;		
		$data[$this->prefijo.'fecha_creacion'] = new Zend_Db_Expr('NOW()');
		if($data[$this->prefijo.'nombre'])
			$data[$this->prefijo.'alias']=Util_Cortartexto::alias($data[$this->prefijo.'nombre']);
		elseif($data[$this->prefijo.'titulo'])
			$data[$this->prefijo.'alias']=Util_Cortartexto::alias($data[$this->prefijo.'titulo']);
				
		return $this->createRow( $data )->save();
	}

	public function edit($data) {

		$id = $this->info('primary');
		$row = $this->find($data[$id[1]])->current();
		$data[$this->prefijo.'fecha_edicion'] = new Zend_Db_Expr('NOW()');
		if($data[$this->prefijo.'nombre'])
			$data[$this->prefijo.'alias']=Util_Cortartexto::alias($data[$this->prefijo.'nombre']);
		elseif($data[$this->prefijo.'titulo'])
			$data[$this->prefijo.'alias']=Util_Cortartexto::alias($data[$this->prefijo.'titulo']);		
			
		$row->setFromArray( $data )->save();
	}	
	/*public function add($data) {
		
		$id = $this->info('primary');
		$data[$id[1]] = null;		
		$data['fc'] = new Zend_Db_Expr('NOW()');		
		return $this->createRow( $data )->save();
	}

	public function edit($data) {

		$id = $this->info('primary');
		$row = $this->find($data[$id[1]])->current();
		$data['fe'] = new Zend_Db_Expr('NOW()');
		$row->setFromArray( $data )->save();
	}*/

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
/*
 *
 * $this->_primary . ' = '.
 * 		$id = $this->info('primary');[$id[1]]
 * $row = 

 */