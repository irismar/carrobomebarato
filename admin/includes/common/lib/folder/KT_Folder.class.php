<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	folder
DESCRIPTION:
	manipulate folders;	
**/
class KT_folder
{
	
	var $errorType = array();				// array	-	error message to be displayed as User Error
	var $develErrorMessage = array();		// array	-	error message to be displayed as Developer Error
		
	function KT_folder() {
		
	}
	
	/**
	NAME:
		checkRights()
	DESCRIPTION:
		verify the rights on the giving folder;
	ARGUMENTS:
		- $folder 		- the absolute path to the folder to be checked
		- $right	 	- the right to be checked: read/write: 
	RETURNS:
		Returns: [boolean]	- true if the right exists on the folder or false if not;
	**/
	function checkRights($folder, $right)
	{
		clearstatcache();
		$folder = $this->preparePath($folder);
		$res = false;
		switch ($right) {
			case 'read':
				if ($this->is_readable($folder)) {
					$res = true;
				}
				break;
			case 'write':
				if ($this->is_writable($folder)) {
					$res = true;
				}
				break;
		}
		return $res;
		
	}
	
	function is_readable($folder)
	{
		if (@opendir($folder)) {
			return true;
		} else {
			return false;
		}
	}
	
	function is_writable($folder)
	{
		$filename = md5(uniqid("")).'.test';
		if (substr($folder, -1)!='\\' && substr($folder, -1)!='/') {
			$filename = DIRECTORY_SEPARATOR.$filename;
		}
		$fd = @fopen($folder.$filename, 'w+');
		if ($fd && file_exists($folder.$filename)) {
			@fclose($fd);
			@unlink($folder.$filename);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	NAME:
		readFolder()
	DESCRIPTION:
		read the content of the folder;
	ARGUMENTS:
		- $folder 		- the absolute path to the folder
		- $details 		- Will return in the array the size for each entry (0 size for any folder).
	RETURNS:
		Returns: [array] - Returns: array with the listing of the folder/files, empty if error occured;
	**/
	function readFolder($folder, $details=false)
	{
		if (!$this->checkRights($folder, 'read')) {
			$this->setError('PHP_FOLDER_READ_ERR', array(), array($folder));
			return array();
		}
		
		$arrDir = array();
		$arrFil = array();
		$folder = $this->preparePath($folder);
		$folder = KT_realpath($folder);
		$dir = dir($folder);
		while (false !== ($entry = $dir->read())) {
			if ($entry != '.' && $entry != '..') {
				if (is_dir($folder . $entry)) {
					$arrDir[] = array('name'=>$entry, 'size'=>0);	
				} else {
					$arrFil[] = array('name'=>$entry, 'size'=>($details==true?filesize($dir->path . $entry):0));
				}	
					
			}	  
		} 
		$dir->close();
		return array('files'=>$arrFil, 'folders'=>$arrDir);
	}
	
	/**
	NAME:
		createFolder()
	DESCRIPTION:
		create recursively the folder;
	ARGUMENTS:
		- $path 		- the absolute path to the folder
	RETURNS:
		Returns: nothing
	**/
	function createFolder($path)
	{
		$path = $this->preparePath($path);
		$path = KT_realpath($path);
		
		$arrCreate = array();
		$arrPath = split("[\\/]", $path);
		if ($arrPath[count($arrPath)-1]=='') {
			array_pop($arrPath);
		}
		
		while (!file_exists(implode(DIRECTORY_SEPARATOR, $arrPath)) && count($arrPath)>0) {
			$arrCreate[] = array_pop($arrPath);
		}
		
		if (count($arrCreate)>0) {
			$arrCreate = array_reverse($arrCreate);
			$folder = implode(DIRECTORY_SEPARATOR, $arrPath);
			
			foreach ($arrCreate as $key => $dir) {
				$folder .= DIRECTORY_SEPARATOR .$dir;
				@mkdir($folder);
				KT_setFilePermissions($folder,true);
				if (!$this->is_writable($folder)) {
					$this->setError('PHP_FOLDER_CREATE_ERR', array(), array($folder));
					return;
				}
			}
		}		
	}
	
	/**
	NAME:
		deleteFolder()
	DESCRIPTION:
		delete recursively the folder;
	ARGUMENTS:
		- $folder 		- the absolute path to the folder 
	RETURNS:
		Returns: nothing
	**/
	function deleteFolder($folder)
	{
		if (!$this->checkRights($folder, 'write')) {
			$this->setError('PHP_FOLDER_DELETE_ERR', array(), array($folder));
			return;
		}
		$folder = $this->preparePath($folder);

		$folder = KT_realpath($folder);
		$d = dir($folder);
		while (false!==($entry = $d->read())) {
			if ($entry == '.' || $entry == '..') {
				continue;
			}
			if (is_dir($d->path . $entry)) {
				$this->deleteFolder($d->path . $entry);
			} else {
				@unlink($folder . $entry);
			}
		}
		$d->close();
		@rmdir($folder);
	}
	
	
	function renameFolder($folder, $oldName, $newName) {
		$folder = KT_realpath($folder);
		if (!$this->checkRights($folder, 'write')) {
			$this->setError('PHP_FOLDER_RENAME_RIGHTS', array(), array($folder));
			return;
		}
		
		if (!file_exists($folder.$oldName)) {
			$this->setError('PHP_FOLDER_RENAME_NO_FILE', array(), array($folder.$oldName));
			return;
		}
		if (file_exists($folder.$newName)) {
			$this->setError('PHP_FOLDER_RENAME_EXISTS', array(), array($folder.$newName));
			return;
		}
		if (!@rename($folder.$oldName, $folder.$newName)) {
			$this->setError('PHP_FOLDER_RENAME', array(), array($folder.$oldName, $folder.$newName));
		}
	}
	/**
	NAME:
		preparePath()
	DESCRIPTION:
		replace the '/' with '\' for windows and '\' with '/' for linux;
	ARGUMENTS:
		- $path 		- the path 
	RETURNS:
		Returns: string - return the translated path;
	**/
	function preparePath($path)
	{
		if (strtolower(substr(PHP_OS, 0, 1))=='w') {
			$path = str_replace('/', '\\', $path);
		} else {
			$path = str_replace('\\', '/', $path);
		}
		return $path;
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
			$this->errorType[] = KT_getResource($errorCode, 'Folder', $arrArgsUsr);
		} else {
			$this->errorType = array();
		}
		if ($errorCodeDev!='') {
			$this->develErrorMessage[] = KT_getResource($errorCodeDev, 'Folder', $arrArgsDev);
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