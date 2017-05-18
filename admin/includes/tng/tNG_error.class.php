<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

class tNG_error {
	var $devDetails;
	var $details;
	var $fieldErrors = array();

	function tNG_error($errorCode, $arrArgsUsr, $arrArgsDev) {
		$this->setDetails($errorCode, $arrArgsUsr, $arrArgsDev);
	}
	
	function setFieldError($fieldName, $errorCode, $arrArgs) {
		$res_errorMsg = KT_getResource($errorCode, 'tNG', $arrArgs);
		$this->fieldErrors[$fieldName] = $res_errorMsg;
	}
	
	function addFieldError($fieldName, $errorCode, $arrArgs) {
		$res_errorMsg = KT_getResource($errorCode, 'tNG', $arrArgs);
		
		if (!isset($this->fieldErrors[$fieldName])) {
			$this->fieldErrors[$fieldName] = $res_errorMsg;
		} else {
			$this->fieldErrors[$fieldName] .= "<br />" . $res_errorMsg;
		}
	}
	
	function getFieldError($fieldName) {
		if (isset($this->fieldErrors[$fieldName])) {
			return $this->fieldErrors[$fieldName];
		}
		return null;
	}
	
	function setDetails($errorCode, $arrArgsUsr, $arrArgsDev) {
		$errorCodeDev = $errorCode;
		if ( !in_array($errorCodeDev, array('', '%s')) ) {
			$errorCodeDev .= '_D';
		}
		$res_details = KT_getResource($errorCode, 'tNG', $arrArgsUsr);
		$res_devDetails = KT_getResource($errorCodeDev, 'tNG', $arrArgsDev);

		$this->details = $res_details;
		$this->devDetails = $res_devDetails;
		if ($errorCode != "%s" && $errorCode != "" && $res_devDetails != "") {
			$this->devDetails .= " (".$errorCode.")";
		}
	}

	function addDetails($errorCode, $arrArgsUsr, $arrArgsDev) {
		if ($this->details != '') {
			$this->details .= "<br />";
		}
		if ($this->devDetails != '') {
			$this->devDetails .= "<br />";
		}
		$errorCodeDev = $errorCode;
		if ( !in_array($errorCodeDev, array('', '%s')) ) {
			$errorCodeDev .= '_D';
		}
		$res_details = KT_getResource($errorCode, 'tNG', $arrArgsUsr);
		$res_devDetails = KT_getResource($errorCodeDev, 'tNG', $arrArgsDev);

		$this->details .= $res_details;
		$this->devDetails .= $res_devDetails;
		if ($errorCode != "%s" && $errorCode != "" && $res_devDetails != "") {
			$this->devDetails .= " (".$errorCode.")";
		}
	}

	function getDetails() {
		$ret = $this->details;
		return $ret;
	}

	function getDeveloperDetails() {
		$ret = $this->devDetails;
		return $ret;
	}
}
?>