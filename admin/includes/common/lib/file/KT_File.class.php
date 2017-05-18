<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	file
DESCRIPTION:
	Provides functionalities for handling files;	
**/
class KT_file
{
	
	var $errorType = array();				// array	-	error message to be displayed as User Error
	var $develErrorMessage = array();		// array	-	error message to be displayed as Developer Error
	
	function KT_file()
	{
	}
	
	function readFile($file) 
	{
		$this->checkFolder($file, 'read', 'Read content');
		if ($this->hasError()) {
			return;
		}
		if ($fd = @fopen($file, 'rb')) {
			$content = fread ($fd, filesize ($file)); 
			@fclose($fd);
			return $content;
		} else {
			$this->setError('PHP_FILE_READ_ERROR', array(), array($file));
		}
	}
	
	function writeFile($file, $mode, $content) 
	{
		$this->checkFolder($file, 'write', 'Write content');
		if ($this->hasError()) {
			return;
		}
		
		switch (strtolower($mode)) {
			case 'truncate':
				$m = 'w';
				break;
			case 'prepend':
				$m = 'r+';
				break;
			case 'append':
			default:
				$m = 'a';
				break;
		}
		$m .= 'b'; 
				
		if ($fd = @fopen($file, $m)) {
			@fwrite($fd, $content); 
			@fclose($fd);
		} else {
			$this->setError('PHP_FILE_WRITE_ERROR', array(), array($file));
		}		
	}
	
	function createFile($file)
	{
		$this->checkFolder($file, 'write', 'Create file');
		if ($this->hasError()) {
			return;
		}
		$fd = fopen($file, 'ab');
		if (!$fd) {
			$this->setError('PHP_FILE_CREATE_ERROR', array(), array($file));
		} else {
			fclose($fd);	
		}
	}
	
	function deleteFile($file)
	{
		$this->checkFolder($file, 'write', 'Delete File');
		if ($this->hasError()) {
			return;
		}
		if (!@unlink($file)) {
			$this->setError('PHP_FILE_DELETE_ERROR', array(), array($file));
		}
	}
	
	function renameFile($file, $newfile) {
		$this->checkFolder($file, 'write', 'Rename File');
		if ($this->hasError()) {
			return;
		}
		$this->checkFolder($newfile, 'write', 'Rename File');
		if ($this->hasError()) {
			return;
		}
		if (!file_exists($file)) {
			$this->setError('PHP_FILE_RENAME_NO_FILE', array(), array($file));
			return;
		}
		if (file_exists($newfile)) {
			$this->setError('PHP_FILE_RENAME_EXISTS', array(), array($file));
			return;
		}
		if (!@rename($file, $newfile)) {
			$this->setError('PHP_FILE_RENAME', array(), array($file, $newfile));
		}
	}
	
	function checkFolder($file, $mode, $from) 
	{
		$folderName = $this->getFolder($file);
		$folder = new KT_folder();
		$folder->createFolder($folderName);
		switch ($mode) {
			case 'read':
				$right = $folder->checkRights($folderName, 'read');
				break;
			case 'write':
			default:
				$right = $folder->checkRights($folderName, 'write');
				break;
		}
		if ($folder->hasError()) {
			$arr = $folder->getError();
			$this->setError('PHP_FILE_FOLDER_ERROR', array($from, $arr[0]), array($from, $arr[1]));
		}
		if ($right !== true) {
			$this->setError('PHP_FILE_CHECK_FOLDER_ERROR', array($from), array($from, $mode, $folderName));
		}
    	
	}
	
	function getFolder($file)
	{
		if (strtolower(substr(PHP_OS, 0, 1))=='w') {
			$file = str_replace('/', '\\', $file);
		} else {
			$file = str_replace('\\', '/', $file);
		}
		$arr = split('[\\/]', $file);
		array_pop($arr);
		return implode(DIRECTORY_SEPARATOR, $arr);
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
			$this->errorType[] = KT_getResource($errorCode, 'File', $arrArgsUsr);
		} else {
			$this->errorType = array();
		}
		if ($errorCodeDev!='') {
			$this->develErrorMessage[] = KT_getResource($errorCodeDev, 'File', $arrArgsDev);
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