<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	email
DESCRIPTION:
	sending simple emails	
**/
class KT_Email
{
	var	$server;				// string	-	Server used for sending email
	var $port;					// string 	- 	Server port used for SMTP sending
	var $user;					// string	-	User used for sending email
	var $password;				// string	-	Password of the user used for sending email
	var $from;					// string	-	from address
	var $to;					// string	-	to address
	var $cc;					// string	-	copy carbon address
	var $bcc;					// string	-	blind copy carbon address
	var $priority;    			// string	-	set the priority for the email;
	var $subject;				// string	-	email subject;
	var $encoding;				// string	-	encoding for body, subject, headers;
	var $textBody;				// string	-	text body;
	var $htmlBody;				// string	-	html body;
	var $errorType = array();				// array	-	error message to be displayed as User Error
	var $develErrorMessage = array();		// array	-	error message to be displayed as Developer Error
	var $KT_CRLF;				// string	-	end of line;

	function KT_Email()
	{
		
	}
	
	/**
	NAME:
		sendEmail()
	DESCRIPTION:
		send the email	
	ARGUMENTS:
		- $server		- string	-	Server used for sending email
		- $port			- string 	- 	Server port used for SMTP sending
		- $user			- string	-	User used for sending email
		- $password		- string	-	Password of the user used for sending email
		- $from			- string	-	from address
		- $to			- string	-	to address
		- $cc			- string	-	copy carbon address
		- $bcc			- string	-	blind copy carbon address
		- $subject		- string	-	email subject;
		- $encoding		- string	-	encoding for body, subject, headers;
		- $textBody		- string	-	text body;
		- $htmlBody		- string	-	html body;
	RETURNS:
		Returns: [string] - empty on succes, error message on error
	**/
	function sendEmail($server, $port, $user, $password, $from, $to, $cc, $bcc, $subject, $encoding, $textBody, $htmlBody)
	{
		$this->server = $server;
		$this->port = $port;
		$this->user	= $user;
		$this->password = $password;
		$this->from = $from;
		$this->to = $to;
		$this->cc = $cc;
		$this->bcc = $bcc;
		$this->subject = $subject;
		$this->encoding = $encoding;
		if ($textBody=='' && $htmlBody!='') {
			$this->textBody = strip_tags($htmlBody);
		} else {
			$this->textBody = $textBody;
		}
		$this->htmlBody = $htmlBody;
		if ($this->KT_CRLF=='') {
			// fix for different os's line endings
			if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN')) {
				$this->KT_CRLF = "\r\n";
			} elseif (strtoupper(substr(PHP_OS, 0, 3) == 'MAC')) {
			 $this->KT_CRLF = "\r";
			} else {
			 $this->KT_CRLF = "\n";
			}
		}
		$auth = true;
		if (strlen(trim($user)) == 0 && strlen(trim($password)) == 0) {
		  $auth = false;
		}

		$mime = new Mail_mime($this->KT_CRLF);
		$mime->setTXTBody($this->getTextBody());
		$mime->setHTMLBody($this->getHtmlBody());
		
		$body = $mime->get($this->getEncodingSettings());
		$headers = $mime->headers($this->getHeaders());
		
		if ($this->server != '') {
			if ($this->from == '') {
				$this->setError('PHP_EMAIL_FROM_NOT_SET' , array(), array());
				return ;
			}
			$arrSMTPParameters = array(
								'host'=>$server,
								'port'=>$port,
								'auth'=>$auth,
								'username'=>$user,
								'password'=>$password
								); 
			$mail_object = &Mail::factory('smtp', $arrSMTPParameters);
			$headers['To'] = $this->getTo();
			$mailresult	= $mail_object->send($this->getSendToSMTP(), $headers, $body);
		} else {
			$mail_object = &Mail::factory('mail');
			$mailresult	= $mail_object->send($this->getSendTo(), $headers, $body);
		}
		
		if ($mailresult!==true) {
			$this->setError('EMAIL_ERROR_SENDING' , array(), array($mailresult->message));
		}
	}
	
	/**
	NAME:
		setPriority()
	DESCRIPTION:
		set the priority	
		1 - High
		3 - Normal
		5 - Low
	ARGUMENTS:
		- $priority		- string	-	priority of the message
	RETURNS:
		Returns: nothing
	**/
	function setPriority($priority='')
	{
		$priority = strtolower($priority);
		switch ($priority) {
			case 'high':
				break;
			case 'low':
				break;
			case 'normal':
			default:
				$priority = 'normal';
				break;
		}
		$this->priority = $priority;
	}

	function getPriority($textual=0)
	{
		if ($this->priority=='')  {
			$this->setPriority();
		}
		if ($textual) {
			return ucfirst($this->priority);
		} else {
			switch ($this->priority) {
				case 'high':
					$priority = 1;
					break;
				case 'low':
					$priority = 5;
					break;
				case 'normal':
				default:
					$priority = 3;
					break;
			}
			return $priority;
		}
	}

	function getTextBody()
	{
		return $this->formatMessageLines($this->textBody, 900);
	}
	
	function getHtmlBody()
	{
		return $this->formatMessageLines($this->htmlBody, 900);	
	}
	
	function getEncodingSettings()
	{
		$arr = array(
                   'html_encoding' => '8bit',
	                 'html_charset'  => $this->encoding,
	                 'text_charset'  => $this->encoding,
	                 'head_charset'  => $this->encoding
	                );
         return $arr;
	}
	
	function getHeaders()
	{
		$arr = array();
		$arr['Subject']	= $this->getSubject();
		$arr['From']	= $this->getFrom();
		// [cor] se pare ca unele servere de mail pun de doua ori adresa to daca o setam si in header si in to de la mail()
		//$arr['To'] = $this->getTo();
		if ($this->getCc()!='') {
			$arr['Cc'] = $this->getCc();
		}
		if ($this->getBcc()!='') {
			$arr['Bcc'] = $this->getBcc();
		}
		$arr['X-Priority'] = $this->getPriority();
		// [cor] se pare ca scad sansele de incadrare ca spam fara asta
		//$arr['X-MSMail-Priority'] = $this->getPriority(1);
		$arr['X-Mailer'] = 'InterAKT tNG mailer';
		return $arr;
	}
	
	function getSubject()
	{
		return $this->prepareText($this->subject);
	}
	
	function getTo()
	{
		return $this->prepareText($this->to);
	}

	function getSendToSMTP()
	{
		$ret = array();
		$to = $this->prepareText($this->to);
		$cc = '';
		$bcc = '';
		if ($this->getCc()!='') {
			$cc = $this->getCc();
		}
		if ($this->getBcc()!='') {
			$bcc = $this->getBcc();
		}
		
		if (preg_match('/.*<([^@]+@[^>]+)>.*/', $to, $matches)) {
			$to = $matches[1];
		}
		$ret[] = $to;
		if ($cc != '') {
			if (preg_match('/.*<([^@]+@[^>]+)>.*/', $cc, $matches)) {
				$cc = $matches[1];
			}
			$ret[] = $cc;
		}
		if ($bcc != '') {
			if (preg_match('/.*<([^@]+@[^>]+)>.*/', $bcc, $matches)) {
				$bcc = $matches[1];
			}
			$ret[] = $bcc;
		}
		return $ret;
	}

	function getSendTo()
	{
		$to = $this->prepareText($this->to);
		if (preg_match('/.*<([^@]+@[^>]+)>.*/', $to, $matches)) {
			$to = $matches[1];
		}
		return $to;
	}

	function getFrom()
	{
		return $this->prepareText($this->from);
	}
	
	function getCc()
	{
		return $this->prepareText($this->cc);
	}
	
	function getBcc()
	{
		return $this->prepareText($this->bcc);
	}
	
	function prepareText($text)
	{
		return trim(str_replace('"', "", $text));
	}	
			
	
	/**
	NAME:
		formatMessageLines
	DESCRIPTION:
		return the message with lines not longer than $chars characters;
	ARGUMENTS:
		$messagetext	-	string	-	text to wrap
		$chars			-	int		- 	number of chars per line;
	RETURNS:
		string - the text with lines wrapped;
	**/
	function formatMessageLines($messagetext, $chars) 
	{
		$messagetext = wordwrap($messagetext, $chars, $this->KT_CRLF);
		return $messagetext;
	}
	
	/**
	NAME:
		setCrlf
	DESCRIPTION:
		set the end of line to use it;
	ARGUMENTS:
		$Crlf	-	string	-	text to wrap
	RETURNS:
		nothing;
	**/
	function setCrlf($Crlf)
	{
		$this->KT_CRLF = $Crlf;
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
      $this->errorType[] = KT_getResource($errorCode, 'Email', $arrArgsUsr);
		} else {
			$this->errorType = array();
		}
		if ($errorCodeDev!='') {
      $this->develErrorMessage[] = KT_getResource($errorCodeDev, 'Email', $arrArgsDev);
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