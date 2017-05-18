<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	shell
DESCRIPTION:
	Execute commands;	
**/
class KT_shell
{
	var $arguments;				// array	-	array containing the arguments for the shell command
	var $errorType = array();				// array	-	error message to be displayed as User Error
	var $develErrorMessage = array();		// array	-	error message to be displayed as Developer Error
		
	function KT_shell()
	{
		
	}
	
	/**
	NAME:
		execute()
	DESCRIPTION:
		execute the command	
	ARGUMENTS:
		- $command 		- array containing the shell command to be executed (just the name of the program, without the full path, just filename)
		- $arguments 	- array containing the arguments for the shell command
	RETURNS:
		Returns: [string] - the output of the execute command
	**/
	function execute($commands, $arguments) {
		session_write_close();
		$this->setArguments($arguments);
		
		$this->checkSystem();
		if  ($this->hasError()) {
			return;
		}
		
		$tmp_e = '';
		
		foreach ($commands as $key => $command) {
			$command = $this->prepareCommand($command);
			$cmd = $command .' '. $this->getArguments();
			ob_start();
			@passthru($cmd, $exit_code);
			//@system($cmd, $exit_code); 
			$output = ob_get_contents();
			ob_end_clean();
			
			if ($exit_code==0) {
				$this->setError('', array(), array());
				$tmp_e = '';
				break;
			} else {
				$tmp_e = 'PHP_SHELL_EXEC_ERROR'; 
			}
		}
		KT_session_start();
		if ($exit_code!=0) {
			$this->setError($tmp_e, array(), array($command . ' '. $this->getArguments(), $exit_code, $output));
			
			/* safe mode */
			if (ini_get("safe_mode")) {
				$this->setError('PHP_SHELL_ERR_SAFE_MODE', array(), array());
			}
			return ;
		} else {
			return $output;
		}
	}
	
	/**
	NAME:
		checkSystem
	DESCRIPTION:
		check if the system(), ob_start(), ob_end_clean, ob_get_contents function are enabled or not;
	ARGUMENTS:
		none;
	RETURNS:
		nothing;
	**/
	function checkSystem()
	{
		if (!function_exists('system')) {
			$this->setError('PHP_SHELL_ERR_SYSTEM_DISABLED', array(), array());
		}	
		if (!function_exists('ob_start')) {
			$this->setError('PHP_SHELL_ERR_OB_S_DISABLED', array(), array());
		}
		if (!function_exists('ob_get_contents')) {
			$this->setError('PHP_SHELL_ERR_OB_G_DISABLED', array(), array());
		}
		if (!function_exists('ob_end_clean')) {
			$this->setError('PHP_SHELL_ERR_OB_E_DISABLED', array(), array());
		}	
	}
	
	/**
	NAME:
		prepareCommand()
	DESCRIPTION:
		for Windows OS and commands with space in path, replace the dir name with short name and return the command without quotes;
		for Linux OS return the command escapeshellcmd;	
	ARGUMENTS:
		- $command 		- string with the command;
	RETURNS:
		Returns: [string] - the output of the execute command
	**/
	function prepareCommand($command)
	{
		if (strtolower(substr(PHP_OS, 0, 1))=='w') {
			return $command;
		} else {
			return escapeshellcmd($command);	
		}
	}
	
	function getArguments()
	{
		if (count($this->arguments) > 0) {
			return implode(" ", $this->arguments);
		} else {
			return "";
		}
	}
				
	function setArguments(&$arguments)
	{
		$test = escapeshellarg('aaaa');
		if (strtolower(substr(PHP_OS, 0, 1))!='w' || (strtolower(substr(PHP_OS, 0, 1))=='w' && substr($test, 0, 1)!="'")) {
			foreach ($arguments as $key => $val) {
				if ($val == '>' || $val == '<') {
					$this->arguments[] = $val;
				} else {
					$this->arguments[] = escapeshellarg($val);
				}
			}
		} else {
			foreach ($arguments as $key => $val) {
				$this->arguments[] = $this->escapeshellarg($val);
			}
		}
	}
	
	/**
	NAME:
		escapeshellarg()
	DESCRIPTION:
		escapeshellarg for windows OS.
	ARGUMENTS:
		- $arg		- string	- argument;
	RETURNS:
		- string - escaped argumet;
	**/
	function escapeshellarg($arg)
	{
		if ($arg != '<' && $arg != '>') {
			$arg = preg_replace("/^\"/", "", $arg);
			$arg = preg_replace("/\"$/", "", $arg);
			$arg = preg_replace("/([^\\\])\"/ims", "$1\\\"", $arg);
			return '"'. $arg .'"';
		} else {
			return $arg;
		}

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
			$this->errorType[] = KT_getResource($errorCode, 'Shell', $arrArgsUsr);
		} else {
			$this->errorType = array();
		}
		if ($errorCodeDev!='') {
			$this->develErrorMessage[] = KT_getResource($errorCodeDev, 'Shell', $arrArgsDev);
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