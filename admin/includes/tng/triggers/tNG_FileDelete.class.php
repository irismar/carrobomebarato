<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	tNGFileDelete
DESCRIPTION:
	Provides functionalities for deleting files.	
**/
class tNG_FileDelete {
	var $tNG;
	var $dbFieldName = '';
	var $folder = '';
	var $rename = false;
	var $renameRule = '';
	
	function tNG_FileDelete(&$tNG) {
		$this->tNG = &$tNG;
	}
	
	
	function setDbFieldName($dbFieldName) {
		$this->dbFieldName = $dbFieldName;
	}

	function setFolder($folder) {
		$this->folder = $folder;
	}
	
	function setRenameRule($renameRule) {
		$this->rename = true;
		$this->renameRule = $renameRule;
	}

	function deleteThumbnails($folder, $oldName) {
		if ($oldName != '') {
			$path_info = KT_pathinfo($oldName);
			$regexp = '/'.preg_quote($path_info['filename'],'/').'_\d+x\d+';
			if ($path_info['extension'] != "") {
				$regexp	.= '\.'.preg_quote($path_info['extension'],'/');
			}
			$regexp	.= '/';
			
			$folderObj = new KT_folder();
			$entry = $folderObj->readFolder($folder, false); 
			
			if (!$folderObj->hasError()) {
				foreach($entry['files'] as $key => $fDetail) {
					if (preg_match($regexp,$fDetail['name'])) {
						@unlink($folder.$fDetail['name']);
					}
				}  
			}
		}
	}

	function Execute() {
		$ret = NULL;
		$folder = KT_realpath(KT_DynamicData($this->folder,$this->tNG,'',true));
		if ($this->rename == false && $this->dbFieldName != '') {
			$fileName = $this->tNG->getSavedValue($this->dbFieldName);
		} else {
			$fileName = KT_DynamicData($this->renameRule , $this->tNG,'', true);
		}
		if ($fileName != "") {
			$fullFileName = $folder . $fileName;
			if (file_exists($fullFileName)) {
				$delRet = @unlink($fullFileName);
				if ($delRet !== true) {
					$ret = new tNG_error('FILE_DEL_ERROR', array(), array($fullFileName));
					$ret->setFieldError($this->fieldName, 'FILE_DEL_ERROR_D', array($fullFileName));
				} else {
					$this->deleteThumbnails($folder.'thumbnails'.DIRECTORY_SEPARATOR, $fileName);
				}
			}
		}
		return $ret;
	}
}
?>