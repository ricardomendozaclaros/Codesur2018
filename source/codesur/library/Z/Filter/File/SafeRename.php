<?php

class Z_Filter_File_SafeRename extends Zend_Filter_File_Rename {

    public function getNewName($value, $source = false)
    {
        $file = $this->_getFileName($value);
		
		//<SAFE
		$safe = new Z_Filter_File_SafeFilename();
		$file['target'] = $safe->filter($file['target']);
		//SAFE>

        if ($file['source'] == $file['target']) {
            return $value;
        }

        if (!file_exists($file['source'])) {
            return $value;
        }

        if (($file['overwrite'] == true) && (file_exists($file['target']))) {
            unlink($file['target']);
        }

        if (file_exists($file['target'])) {
            require_once 'Zend/Filter/Exception.php';
            throw new Zend_Filter_Exception(sprintf("File '%s' could not be renamed. It already exists.", $value));
        }

        if ($source) {
            return $file;
        }

        return $file['target'];
    }
}
