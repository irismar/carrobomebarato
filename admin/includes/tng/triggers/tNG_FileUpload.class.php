<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	tNG_FileUpload
DESCRIPTION:
	Provides functionalities for handling tNG based file uploads.	
**/
class tNG_FileUpload{
	var $tNG;
	var $fieldName;
	var $errObj;
	
	function tNG_FileUpload(&$tNG) {
		$this->tNG = &$tNG;
		$this->formFieldName = "";
		$this->dbFieldName = "";
		$this->folder = "";
		$this->maxSize = 0;
		$this->allowedExtensions = array();
		$this->rename  = "none";
		$this->renameRule  = "";
		$this->uploadedFileName = "";
		$this->errObj = null;
	}
	
	function setFormFieldName($formFieldName) {
		$this->formFieldName = $formFieldName;
	}

	function setDbFieldName($dbFieldName) {
		$this->dbFieldName = $dbFieldName;
	}
	
	function setFolder($folder) {
		$this->folder = $folder;
	}
	
	function setMaxSize($maxSize) {
		$this->maxSize = $maxSize;
	}
	
	function setAllowedExtensions($allowedExtensions) {
		$arrExtensions = explode(',',$allowedExtensions);
		for($i=0;$i<count($arrExtensions);$i++) {
			$arrExtensions[$i] = trim($arrExtensions[$i]);
		}
		$this->allowedExtensions = $arrExtensions;
	}
	function setRename($rename) {
		$this->rename = $rename;
	}
	function setRenameRule($renameRule) {
		$this->renameRule = $renameRule;
	}

	function RollBack() {
		@unlink($this->dynamicFolder.$this->uploadedFileName);
	}
	
	function deleteThumbnails($folder, $oldName) {
	}

	
	function Execute() {
		if ($this->tNG->getTransactionType() == "_csvimport") {
			$this->tNG->CSVuploadObj = &$this;
		}
		$ret = null;
		if ($this->dbFieldName != '') {
			$oldFileName = $this->tNG->getSavedValue($this->dbFieldName);
			$saveFileName = $this->tNG->getColumnValue($this->dbFieldName);
			if ($this->tNG->getColumnType($this->dbFieldName) != 'FILE_TYPE') {
				$errObj = new tNG_error('FILE_UPLOAD_WRONG_COLTYPE', array(), array($this->dbFieldName));
				$errObj->addFieldError($this->dbFieldName, 'FILE_UPLOAD_WRONG_COLTYPE_D', array($this->dbFieldName));
				return $errObj;
			}
		} else {
			$oldFileName =KT_DynamicData($this->renameRule,$this->tNG,'',true);
			if (isset($this->tNG->multipleIdx)) {
				$saveFileName = @$_FILES[$this->formFieldName."_".$this->tNG->multipleIdx]['name'];
			} else {
				$saveFileName = @$_FILES[$this->formFieldName]['name'];
			}
		}
		$this->dynamicFolder = KT_DynamicData($this->folder,$this->tNG,'',false);
		$arrArgs = array();
		$autoRename = false;
		switch ($this->rename) {
			case 'auto':
				$autoRename = true;
				break;
			case 'none':
				break;
			case 'custom':
				$path_info = KT_pathinfo($saveFileName);
				$arrArgs = array('KT_name' => $path_info['filename'], 'KT_ext' => $path_info['extension']);
				$saveFileName = KT_DynamicData($this->renameRule,$this->tNG,'',false,$arrArgs);
				break;
			default:
				die('INTERNAL ERROR: Unknown upload rename method.');
		}
		// Upload File
		$fileUpload = new KT_fileUpload();
		if (isset($this->tNG->multipleIdx)) {
			$fileUpload->setFileInfo($this->formFieldName."_".$this->tNG->multipleIdx);
		} else {
			$fileUpload->setFileInfo($this->formFieldName);
		}
		$fileUpload->setFolder($this->dynamicFolder);
		$fileUpload->setRequired(false);
		$fileUpload->setAllowedExtensions($this->allowedExtensions);
		$fileUpload->setAutoRename($autoRename);
		$fileUpload->setMaxSize($this->maxSize);
		$this->uploadedFileName = $fileUpload->uploadFile($saveFileName, $oldFileName);
		
		$updateDB = basename($this->uploadedFileName);
		if ($fileUpload->hasError()) {
			$arrError = $fileUpload->getError();
			$errObj = new tNG_error('FILE_UPLOAD_ERROR', array($arrError[0]), array($arrError[1]));
			if ($this->dbFieldName != '') {
				$errObj->addFieldError($this->dbFieldName, '%s', array($arrError[0]));
			}
			$ret = $errObj;
		} else {
			$this->dynamicFolder = KT_realpath($this->dynamicFolder);
			if ($this->uploadedFileName == "") {
				//Check if for update we need to rename file
				if ($this->rename == "custom") {
					$path_info = KT_pathinfo($oldFileName);
					$arrArgs['KT_ext'] = $path_info['extension'];
				}
				$tmpFileName = KT_DynamicData($this->renameRule,$this->tNG,'',false, $arrArgs);
				if ($tmpFileName != "" && $oldFileName != "" && $tmpFileName != $oldFileName) {
					if (file_exists($this->dynamicFolder.$oldFileName)) {
						if (@rename($this->dynamicFolder.$oldFileName, $this->dynamicFolder.$tmpFileName) === true) {
							$this->uploadedFileName = $tmpFileName;
							$updateDB = basename($this->uploadedFileName);
						} else {
							$ret = new tNG_error('FILE_UPLOAD_RENAME', array(), array($this->dynamicFolder.$oldFileName, $this->dynamicFolder.$tmpFileName));
						}
					}
				}
			}

			if ($ret === null) {
				if ($this->tNG->getTransactionType() == "_insert" || $this->tNG->getTransactionType() == "_multipleInsert") {
					$this->tNG->registerTrigger('ERROR', 'Trigger_Default_RollBack', 1, $this);
				}
				
				$this->deleteThumbnails($this->dynamicFolder .'thumbnails'.DIRECTORY_SEPARATOR, $oldFileName);
				if ($this->uploadedFileName != '') {
					$this->deleteThumbnails($this->dynamicFolder.'thumbnails'.DIRECTORY_SEPARATOR, $this->uploadedFileName);
				}

				if ($this->dbFieldName != '' && $this->uploadedFileName != "") {
					$ret = $this->tNG->afterUpdateField($this->dbFieldName, $updateDB);
				}
			}
			if ($ret === null && $this->dbFieldName != "") {
				$this->tNG->setRawColumnValue($this->dbFieldName,$updateDB);
			}
		}
		$this->errObj = $ret;
		return $ret;
	}
}
?>