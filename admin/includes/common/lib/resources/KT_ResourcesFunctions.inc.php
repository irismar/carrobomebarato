<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

function KT_getResource($resourceName='default', $dictionary='default', $args = array()) {
	if (!isset($GLOBALS['interakt']['resources'])) {
		$GLOBALS['interakt']['resources'] = array();
	}
	$dictionaryFileName = KT_realpath(dirname(realpath(__FILE__)). '/../../../resources/'). $dictionary .'.res.php';
	$resourceValue = $resourceName;
	
	if (!isset($GLOBALS['interakt']['resources'][$dictionary])) {
		@include($dictionaryFileName);
		if (isset($res)) {
			$GLOBALS['interakt']['resources'][$dictionary] = $res;
		}
	}

	if (isset($GLOBALS['interakt']['resources'][$dictionary][$resourceName])) {
		$resourceValue = $GLOBALS['interakt']['resources'][$dictionary][$resourceName];
	} else {
		/*if (trim($resourceName) != "" && trim($resourceName) != "%s") {
			die("<br />Resource '".$resourceName."' not defined in dictionary '".$dictionary."'.<br />");
		}*/
		if (substr($resourceValue,-2) == "_D") {
			$resourceValue = substr($resourceValue,0,-2);
		}
	}

	if (count($args) > 0) {
		array_unshift($args, $resourceValue);
		$resourceValue = call_user_func_array('sprintf', $args);
	}
	return $resourceValue;
}
?>