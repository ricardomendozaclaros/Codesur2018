<?php
class Admin_Model_Administrador_Administrador extends Z_Admin_Table {
	protected $_name = 'administrador';
	public $prefijo="";
	
	public function add($data) {
		
		$id = $this->info('primary');
		$data[$id[1]] = null;		
		$data['fecha']=new Zend_Db_Expr('now()');
		$data['pass']=sha1($data['pass']);
		return $this->createRow( $data )->save();
	}

	public function edit($data) {

		$id = $this->info('primary');
		$row = $this->find($data[$id[1]])->current();
		$data['pass']=sha1($data['pass']);			
		$row->setFromArray( $data )->save();
	}	
				
}
