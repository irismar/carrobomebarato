<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

function tNG_downloadDynamicFile($siteRootPath, $dynamicFolder, $dynamicFileName) {
	$ret = "";
	
	$folder = KT_DynamicData($dynamicFolder,null);
	$fileName = KT_DynamicData($dynamicFileName,null);
	$folder = KT_realpath($folder);
	$absPath = KT_realpath($folder . $fileName, false);
	
	if ($fileName != '' && file_exists($absPath)) {
		$now = time();
		if (isset($_SESSION['tNG']['download'])) {
			if (is_array($_SESSION['tNG']['download'])) {
				foreach($_SESSION['tNG']['download'] as $tmpId => $detail) {
					if ($detail['time'] < $now - 60*5) {
						unset($_SESSION['tNG']['download'][$tmpId]);
					}
				}
			} else {
				$_SESSION['tNG']['download'] = array();
			}
			
		} else {
			$_SESSION['tNG']['download'] = array();
		}
		
		$uniqueId = md5($absPath);
		if (!isset($_SESSION['tNG']['download'][$uniqueId])) {
			$downloadInfo = array();
			$downloadInfo['realPath'] = $absPath;
			$downloadInfo['fileName'] = $fileName;
			$downloadInfo['time'] = $now;
			$_SESSION['tNG']['download'][$uniqueId] = $downloadInfo;
		}
		if ($siteRootPath != "") {
			$siteRootPath = str_replace("\\", "/", $siteRootPath);
			if (substr($siteRootPath, strlen($siteRootPath)-1) != '/') {
				$siteRootPath .= '/';
			}
		}
		$ret = $siteRootPath."includes/tng/pub/tNG_download.php?id=".rawurlencode($uniqueId);
	}
	return $ret;
}
/**
 * Checks if a file specified by the dynamic folder and dynamic file expressions exists
 * @param string $dynamicFolder the folder name (may be a tNG dynamic expression)
 * @param string $dynamicFileName the file name (may be a tNG dynamic expression)
 * @return boolean
 *         true if the file exists, 
 *         false if the file does not exist
 */
function tNG_fileExists($dynamicFolder, $dynamicFileName) {
	$ret = false;
	
	$folder = KT_DynamicData($dynamicFolder,null);
	$fileName = KT_DynamicData($dynamicFileName,null);
	
	if ($fileName != "") {
		$folder = KT_realpath($folder);
		$relPath = KT_realpath($folder . $fileName, false);
		$ret = file_exists($relPath);
	}
	return $ret;
}

/**
 * Creates and returns the image relative path using the dynamic folder and dynamic file expressions
 * @param string $dynamicFolder the folder name (may be a tNG dynamic expression)
 * @param string $dynamicFileName the file name (may be a tNG dynamic expression)
 * @return string
 *         the relative path to the image file, 
 *         empty if the dynamicFileName is empty
 */
function tNG_showDynamicImage($siteRootPath, $dynamicFolder, $dynamicFileName) {
	$folder = KT_DynamicData($dynamicFolder,null);
	$fileName = KT_DynamicData($dynamicFileName,null);
	$folder = str_replace("\\", "/", $folder);
	if (substr($folder, strlen($folder)-1) != '/') {
		$folder .= '/';
	}
	$relPath = $folder . $fileName;

	if ( $fileName == '' || !file_exists(KT_realpath($relPath, false)) ) {
		$relPath = $siteRootPath . "includes/tng/styles/img_not_found.gif";
	}
	return $relPath;
}

/**
 * Creates and returns the relative path of an image thumbnail using the dynamic folder and dynamic file expressions
 * @param string $dynamicFolder the folder name (may be a tNG dynamic expression)
 * @param string $dynamicFileName the file name (may be a tNG dynamic expression)
 * @param integer $width the width of the thumbnail to be created
 * @param integer $height the width of the thumbnail to be created
 * @param boolean $proportional specify if the thumbnail preserve the proportions of the original image
 * @return string
 *         the relative path to the image file, 
 *         empty if the dynamicFileName is empty or if the thumbnail could ne be created
 */
function tNG_showDynamicThumbnail($siteRootPath, $dynamicFolder, $dynamicFileName, $width, $height, $proportional) {
	$relPath = "";
	
	$folder = KT_DynamicData($dynamicFolder,null);
	$fileName = KT_DynamicData($dynamicFileName,null);
	$folder = str_replace("\\", "/", $folder);
	if (substr($folder, strlen($folder)-1) != '/') {
		$folder .= '/';
	}
	$relPath = $folder . $fileName;
	
	if ( $fileName != '' && file_exists(KT_realpath($relPath, false)) ) {
		$path_info = KT_pathinfo($fileName);
		$thumbnailFolder = $folder .'thumbnails/';
		$thumbnailName = $path_info['filename'].'_'.(int)$width.'x'.(int)$height.(isset($path_info['extension'])?'.'.$path_info['extension']:'');
		$relPath = $thumbnailFolder . $thumbnailName;
		if ( !file_exists(KT_realpath($thumbnailFolder . $thumbnailName, false)) ) {
			$image = new KT_image();
			$image->setPreferedLib($GLOBALS['tNG_prefered_image_lib']);
			$image->addCommand($GLOBALS['tNG_prefered_imagemagick_path']);
			$image->resize(KT_realpath($folder . $fileName, false), KT_realpath($thumbnailFolder), $thumbnailName, (int)$width, (int)$height, $proportional);
			if ($image->hasError()) {
				$errorArr = $image->getError();
				if ($GLOBALS['tNG_debug_mode'] == 'DEVELOPMENT') {
					$errMsg = $errorArr[1];
					$relPath = $siteRootPath . "includes/tng/styles/cannot_thumbnail.gif\" />".$errMsg."<img src=\"".$siteRootPath."includes/tng/styles/cannot_thumbnail.gif";
				} else {
					$relPath = $siteRootPath . "includes/tng/styles/cannot_thumbnail.gif";
				}
			}
		}
	} else {
		$relPath = $siteRootPath . "includes/tng/styles/img_not_found.gif";
	}
	return $relPath;
}

/**
 * Checks if the value for a given expression changed
 * @param string $fieldName unique identifier of the expression to be checked for change
 * @param any $fieldValue the value of the expression to be checked
 * @return boolean
 *         true if the field value has changed
 *         false if not
 */
function tNG_fieldHasChanged($fieldName, $fieldValue) {
	static $values;
	$retVal = false;
	if (!isset($values[$fieldName]) || $values[$fieldName] != $fieldValue) {
		$retVal = true;
	}
	$values[$fieldName] = $fieldValue;
	return $retVal;
}

function tNG_getEscapedStringFromMessage(&$string) {
	$newmessage = preg_replace('/\{[^\s}]+\}/', '%s', $string);
	return $newmessage;
}

/**
 * Sets the value for a specific column
 * @param array &$colDetails column details (one element of the $column array)
 * @access private
 */
function tNG_prepareValues(&$colDetails) {
	$type2alt = array(
		'CHECKBOX_1_0_TYPE'=>'1',
		'CHECKBOX_-1_0_TYPE'=>'-1',
		'CHECKBOX_YN_TYPE'=>"Y",
		'CHECKBOX_TF_TYPE'=>"t",
	);
	if (isset($colDetails['method']) && isset($colDetails['reference']) && isset($colDetails['type'])) {
		$colValue = KT_getRealValue($colDetails['method'], $colDetails['reference']);
		if ($colDetails['method'] == 'VALUE') {
			$colValue = KT_DynamicData($colValue, null);
			if (isset($colDetails['default'])) {
				$colDetails['default'] = $colValue;
			}
		} elseif (isset($colDetails['default'])) {
			$colDetails['default'] = KT_DynamicData($colDetails['default'], null);
		}
		switch ($colDetails['type']) {
			case 'CHECKBOX_YN_TYPE':
			case 'CHECKBOX_1_0_TYPE':
			case 'CHECKBOX_-1_0_TYPE':
			case 'CHECKBOX_TF_TYPE':
				$colValue = !isset($colValue) ?  '' : $type2alt[$colDetails['type']];
				break;
			case 'DATE_TYPE':
			case 'DATE_ACCESS_TYPE':
				$colValue = KT_formatDate2DB($colValue);
				if (isset($colDetails['default'])) {
					$colDetails['default'] = KT_formatDate2DB($colDetails['default']);
				}
				break;
		}
	} else {
		$colValue = "";
	}
	$colDetails['value'] =  $colValue;
}

// Session functions
function tNG_getRememberMePath() {
	$tNGinc_path = KT_getSiteRoot() . '/';
	
	$absPath_running_script = $_SERVER['PATH_TRANSLATED']; 
	$absPath_running_script = str_replace("\\", "/", $absPath_running_script);

	// try to match $tNGinc_path into $absPath_running_script and get the remainings 
	// ( remainings = the relative path of the current file to the root of the site)

	$pos = strpos(strtolower($absPath_running_script), strtolower($tNGinc_path));
	if ($pos === false) {
		$valability_path = "/";
	} else {
		// build the relPath_running_script as the remaining after removing $tNGinc_path from $absPath_running_script
		$relPath_running_script = substr($absPath_running_script, $pos + strlen($tNGinc_path));
		
		$url_running_script = $_SERVER['PHP_SELF'];
		// to get valability path must remove $relPath_running_script from $url_running_script
		$pos = strpos(strtolower($url_running_script), strtolower($relPath_running_script));
		if ($pos === false) {
			$valability_path = "/";
		} else {
			$valability_path = substr($url_running_script, 0, $pos);
		}
	}
	$parts = explode("/",$valability_path);
	$partsURL = array_map("rawurlencode",$parts);
	$valability_path = implode("/", $partsURL);
	return $valability_path;
}


function tNG_generateRandomString($len) {
	//make a seed for the random generator
	list($usec, $sec) = explode(' ', microtime());
	$seed =  (float) $sec + ((float) $usec * 100000);
	//generate a new random value
	srand($seed);
	$newstring = md5(rand());
	if ($len) {
		return substr($newstring,0,$len);
	} else {
		return $newstring;
	}
}


function tNG_encryptString($plain_string) {
	$encrypted_string = md5($plain_string);
	return $encrypted_string;
}

function tNG_activationLogin(&$connection) {
	if (isset($_GET['kt_login_id']) && isset($_GET['kt_login_random'])) {
		// make an instance of the transaction object
		$loginTransaction_activation = new tNG_login($connection);
		// register triggers
		// automatically start the transaction
		$loginTransaction_activation->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "1");

		// add columns
		$loginTransaction_activation->setLoginType('activation');
		$loginTransaction_activation->addColumn("kt_login_id", $GLOBALS['tNG_login_config']['pk_type'] , "GET", "kt_login_id");
		$loginTransaction_activation->addColumn("kt_login_random", "STRING_TYPE", "GET", "kt_login_random");
		 
		$loginTransaction_activation->executeTransaction();
		if (isset($loginTransaction_activation->columns["kt_login_redirect"])) {
			// return already computed redirect page
			return $loginTransaction_activation->getColumnValue("kt_login_redirect");
		}
	}
	return "";
}


function tNG_cookieLogin(&$connection) {
	if (isset($_SESSION['kt_login_user'])) {
		return;
	}
	if (isset($_SESSION['kt_login_id']) && isset($_SESSION['kt_login_test'])) {
		// make an instance of the transaction object
		$loginTransaction_cookie = new tNG_login($connection);
		// register triggers
		// automatically start the transaction
		$loginTransaction_cookie->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "1");

		// add columns
		$loginTransaction_cookie->setLoginType('cookie');
		$loginTransaction_cookie->addColumn("kt_login_id", $GLOBALS['tNG_login_config']['pk_type'] , "COOKIE", "kt_login_id");
		$loginTransaction_cookie->addColumn("kt_login_test", "STRING_TYPE", "COOKIE", "kt_login_test");
		 
		$loginTransaction_cookie->executeTransaction();
	}
}

function NXT_getResource($resourceName) {
	return KT_getResource($resourceName, 'NXT');
}

?>