<?php
class Z_Db_Table extends Zend_Db_Table {

	public function add($data) {

		$data['id'] = null;
		return $this->createRow( $data )->save();
	}

	public function edit($data) {

		$row = $this->find($data['id'])->current();
		$row->setFromArray( $data )->save();
	}

	public function del($data) {
		$this->find($data)->current()->delete();
	}
}
