<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	fileUpload
DESCRIPTION:
	Provides functionalities for handling file uploads
**/
class KT_fileUpload
{
	
	var $fileInfo;				// array	-	the file upload information
	var $fileExists;      // boolean	-	
	var $folder;				// string	-	destination folder for upload
	var $isRequired;			// bollean	-	specifies if the file is required for upload or not
	var $allowedExtensions;		// array	-	the allowed types for upload
	var $autoRename;			// boolean	-	
	var $minSize;				// int		-	minimum allowed size of the uploaded file in KB;
	var $maxSize;				// int		-	maximum allowed size of the uploaded file in KB;
	var $oldFileName;			// string	-	Specifies the old file name that is allowed to be overwritten in case that its name is the same as the file to be uploaded (fileName)
	var $destinationName;		// string	-	the name under which the file was saved after upload
	var $errorType =  array();				// array	-	error message to be displayed as User Error
	var $develErrorMessage = array();		// array	-	error message to be displayed as Developer Error
	
	function KT_fileUpload()
	{
		$this->folder = '';
		$this->isRequired = false;
		$this->allowedExtensions = array();
		$this->autoRename = false;
		$this->minSize= 1;
		$this->maxSize=-1;
		$this->error = 0;
		$this->errorType = array();
		$this->develErrorMessage = array();
	}
	
	function setFileInfo($fileInfo)
	{
		if (isset($_FILES[$fileInfo])) {
			$this->fileInfo = $_FILES[$fileInfo];
		} else {
			$this->setError('PHP_UPLOAD_NO_UPLOAD', array(), array($fileInfo));
			if (count($_POST) == 0) {
				$this->setError('PHP_UPLOAD_NO_POST', array(), array());
			}
			$file_uploads = @ini_get('file_uploads');
			if (strlen(trim($file_uploads)) == 0) {
				$this->setError('PHP_UPLOAD_UPLOAD_DISABLED', array(), array());
			}
		}
	}
	
	function setFolder($folder)
	{
		$this->folder = $folder;
		if (strtolower(substr(PHP_OS, 0, 1))=='w') {
			$this->folder = str_replace('/', '\\', $this->folder);
		} else {
			$this->folder = str_replace('\\', '/', $this->folder);
		}
	}
	
	function setRequired($isRequired)
	{
		$this->isRequired = $isRequired;
	}

	function setAllowedExtensions($allowedExtensions)
	{
		$this->allowedExtensions = $allowedExtensions;
	}
	
	function setAutoRename($autoRename)
	{
		$this->autoRename = $autoRename;
	}
	
	function setMinSize($minSize)
	{
		$this->minSize = $minSize;
	}
	
	function setMaxSize($maxSize)
	{
		$this->maxSize = $maxSize;	
	}
	
	/**
	NAME:
		uploadFile
	DESCRIPTION:
		Handle the uploaded file by moving it to a destination file.
		The destination file = folder + fileName
	ARGUMENTS:
		$fileName	-	string	-	the name for saving the uploaded file
		$oldFileName	-	string	-	the previous file name, or null on insert
	RETURNS:
		file name if succeded or null if not;
	**/
	function uploadFile($fileName, $oldFileName="")
	{
		if ($this->hasError()) {
			return;
		}
		$this->checkUpload();
		$this->checkFolder();
		$this->checkSize();
		$this->checkExtensions();
		$this->checkFileName($fileName);
		if ($this->hasError()) {
			return;
		}

		if ($this->fileExists) {
			$folder = KT_realpath($this->folder);
			$destinationName = KT_realpath($folder . $fileName, false);
			if (file_exists($destinationName)) {
				if (strtolower($fileName) != strtolower($oldFileName)) {
					// if the destination file really exists
					if (!$this->autoRename) {
						$this->setError('UPLOAD_FILE_EXISTS', array(), array($fileName));
						return;
					} else {
						$destinationName = $this->getTempName($destinationName);
					}
				}
			}
			
			if ($oldFileName!='') {
				@unlink($folder . DIRECTORY_SEPARATOR . $oldFileName);
			}

			if (!@move_uploaded_file($this->fileInfo['tmp_name'], $destinationName)) {
				unlink($this->fileInfo['tmp_name']);
				$this->setError('PHP_UPLOAD_MOVE_TMP_ERROR', array(), array());
				return;
			} else {
				$arr = split("[\\/]", $destinationName);
				$this->destinationName = $destinationName;
				KT_setFilePermissions($this->destinationName);
				return array_pop($arr);
			}
		}
    
	}
	
	
	/**
	NAME:
		getTempName()
	DESCRIPTION:
		Gets a temporary file name starting from the given file name.
			Ex: filename = 'zone.jpg', and zone_1.jpg alreagy exists, the new file name is zone_2.jpg.
	ARGUMENTS:
		$filename	-	string	-	the filename on which to create the new temporary file name.
	RETURNS:
		string - the temporary file name
	**/
	function getTempName($filename) {
		$pos = strrpos($filename,'.');
		if ($pos !== false) {
			$tmpName = substr($filename,0,$pos);
			$tmpExt = substr($filename, $pos);
		} else {
			$tmpName = $filename;
			$tmpExt = '';
		}
		$i=1;
		while (file_exists($tmpName.'_'.$i.$tmpExt) && $i < 1000) {
			$i++;
		}
		$retVar = $tmpName.'_'.$i.$tmpExt;
		return $retVar;
	}
	
	/**
	NAME:
		checkFolder()
	DESCRIPTION:
		Check if the uploaded folder exists and has write permissions.
		If the folder does not exists, try to create it.
		If the folder does not have write permissions or if could not create it, set error.
	ARGUMENTS:
		- none
	RETURNS:
		nothing
	**/
	function checkFolder() {
		if ($this->fileExists) {
			$folder = new KT_folder();
			$folder->createFolder($this->folder);
			$right = $folder->checkRights($this->folder, 'write');
			
			if ($folder->hasError()) {
				$arr = $folder->getError();
				$this->setError('PHP_UPLOAD_FOLDER_ERROR', array($arr[0]), array($arr[1]));
			}
			if ($right !== true) {
				$this->setError('PHP_UPLOAD_CHECK_FOLDER_ERROR', array(), array($this->folder));
			}
		}
	}
	
	/**
	NAME:
		checkSize()
	DESCRIPTION:
		Checks the size of the uploaded folder.
		The size is checked against the $this->minSize and $this->maxSize
	ARGUMENTS:
		- none
	RETURNS:
		nothing
	**/
	function checkSize() {
		if ($this->fileExists) {
			if ($this->minSize >0 && $this->fileInfo['size'] < $this->minSize) {
				$this->setError('UPLOAD_CHECK_SIZE_S', array($this->minSize-1), array($this->minSize-1));
				return;
			}
			if ($this->maxSize >0 && $this->fileInfo['size'] > $this->maxSize * 1024) {
				$this->setError('UPLOAD_CHECK_SIZE_G', array($this->maxSize), array($this->maxSize));
				return;
			}
		}
	}
	
	/**
	NAME:
		checkExtensions()
	DESCRIPTION:
		Checks the type of the uploaded folder.
		The name is checked against the $this->allowedTypes array.
	ARGUMENTS:
		- none
	RETURNS:
		nothing
	**/
	function checkExtensions() {
		if ($this->fileExists) {
			$path_info = KT_pathinfo($this->fileInfo['name']);
			foreach ($this->allowedExtensions as $key => $extension) {
				if (strtolower($extension) == strtolower($path_info['extension'])) {
					return;
				}
			}
			$this->setError('UPLOAD_EXT_NOT_ALLOWED', array(), array($path_info['extension']));
		}
	}
	
	
	function checkFileName($fileName) {
		if ($this->fileExists) {
			$arrInvalid = array('..','\\','/',':','*','?','"','<','>','|');
			if ((string)$fileName == '') {
				$this->setError('PHP_UPLOAD_FILENAME_EMPTY', array(), array());
				return;
			}
			foreach($arrInvalid as $key => $tmp) {
				if (strpos($fileName,$tmp) !== false) {
					$this->setError('PHP_UPLOAD_FILENAME_INV', array(), array($tmp));
					return;
				}
			}
		}
	}
	
	/**
	NAME:
		checkUpload()
	DESCRIPTION:
		Checks if the upload has performed OK and if the file is required.
	ARGUMENTS:
		- none
	RETURNS:
		nothing
	**/
	function checkUpload() {
		if ($this->fileInfo['tmp_name'] == "" || !file_exists($this->fileInfo['tmp_name'])) {
			$this->fileExists = false;
			if (isset($this->fileInfo['error']) && !is_array($this->fileInfo['error']) && $this->fileInfo['error'] >0) {
				switch ($this->fileInfo['error']){
					case 1:
						$this->setError('PHP_UPLOAD_ERR_INI_SIZE', array(), array());
						return;
					case 2:
						$this->setError('PHP_UPLOAD_ERR_FORM_SIZE', array(), array());
						return;
					case 3:
						$this->setError('PHP_UPLOAD_ERR_PARTIAL', array(), array());
						return;
					case 4:
						break;
					default:
						$this->setError('PHP_UPLOAD_ERR_UNKNOWN', array(), array($this->fileInfo['error']));
						return;
				}
			} else {
				$this->setError('PHP_UPLOAD_ERR_TMP_DIR', array(), array());
			}
		} else {
			$this->fileExists = true;
			if (isset($this->fileInfo['size']) && $this->fileInfo['size'] == 0) {
				$this->fileExists = false;
			}
		}
		
		if (!is_uploaded_file($this->fileInfo['tmp_name'])) {
			if($this->isRequired) {
				if ($this->fileInfo['tmp_name'] != ''){
					$this->setError('PHP_UPLOAD_ERR_TMP_FILE', array(), array($this->fileInfo['tmp_name']));
					return;
				} elseif ($this->fileInfo['error'] == 4) {
					$this->setError('PHP_UPLOAD_FILE_REQUIRED', array(), array());
					return;
				}
			}
		}
	}
	
	/**
	NAME:
		RollBack()
	DESCRIPTION:
		Makes RollBack if transaction failed.
	ARGUMENTS:
		- none
	RETURNS:
		- nothing
	**/
	function RollBack() {
		@unlink($this->destinationName);
	}
	
	/**
	NAME:
		setError()
	DESCRIPTION:
		set error for developper and user.
	ARGUMENTS:
		- $errorCode		- string	- error message code;
		- $arrArgsUsr		- array		- array with optional parameters for sprintf functions.
		- $arrArgsDev		- array		- array with optional parameters for sprintf functions.
	RETURNS:
		- nothing
	**/
	function setError($errorCode, $arrArgsUsr, $arrArgsDev)
	{
		$errorCodeDev = $errorCode;
		if ( !in_array($errorCodeDev, array('', '%s')) ) {
			$errorCodeDev .= '_D';
		}
		if ($errorCode!='') {
			$this->errorType[] = KT_getResource($errorCode, 'FileUpload', $arrArgsUsr);
		} else {
			$this->errorType = array();
		}
		if ($errorCodeDev!='') {	
			$this->develErrorMessage[] = KT_getResource($errorCodeDev, 'FileUpload', $arrArgsDev);
		} else {
			$this->develErrorMessage = array();
		}
	}
	
	/**
	NAME:
		hasError()
	DESCRIPTION:
		check if an error was setted.
	ARGUMENTS:
		none
	RETURNS:
		- boolean - true if error is set or false if not;
	**/
	function hasError()
	{	
		if (count($this->errorType)>0 || count($this->develErrorMessage)>0) {
			return 1;	
		}	
		return 0;
	}
		
	/**
	NAME:
		getError()
	DESCRIPTION:
		return the errors setted.
	ARGUMENTS:
		none
	RETURNS:
		- array - 0=>error for user, 1=>error for developer;
	**/	
	function getError()
	{
		return array(implode('<br />', $this->errorType), implode('<br />', $this->develErrorMessage));	
	}

}
?>