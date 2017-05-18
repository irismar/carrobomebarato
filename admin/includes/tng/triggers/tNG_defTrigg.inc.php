<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/**
 * Default Starter trigger 
 * Verifies if additional parameters are set and if not invalidate the transaction
 * this is usefull for verifying some global variables.
 * Type: STARTER
 */
function Trigger_Default_Starter(&$tNG, $method, $reference) {
	$ret = KT_getRealValue($method, $reference);
	if (isset($ret)) {
		$tNG->setStarted(true);
	}
	return null;
}

/**
 * Default Redirect trigger 
 * Type: ERROR
 */
function Trigger_Default_Redirect(&$tNG, $page) {
	$redObj = new tNG_Redirect($tNG);
	$redObj->setURL($page);
	$redObj->setKeepURLParams(false);
	return $redObj->Execute();
}

/**
 * Default Form Validation trigger
 * Type: BEFORE
 */
function Trigger_Default_FormValidation(&$tNG, &$uniVal) {
	$uniVal->setTransaction($tNG);
	return $uniVal->Execute();
}

/**
 * Default Insert RollBack trigger
 * Type: ERROR
 */
function Trigger_Default_Insert_RollBack(&$tNG) {
	$keyName = $tNG->getPrimaryKey();
	$keyValue = $tNG->getPrimaryKeyValue();
	$keyType = $tNG->getColumnType($keyName);
	$escapedKeyValue = KT_escapeForSql($keyValue, $keyType);
	$sql = "DELETE FROM " . $tNG->getTable() . " WHERE " . KT_escapeFieldName($keyName) . " = " . $escapedKeyValue;
	$tNG->connection->Execute($sql);
	return null;
}

/**
 * Default RollBack trigger
 * Type: ERROR
 */
function Trigger_Default_RollBack(&$tNG, &$obj) {
	$obj->RollBack();
	return null;
}

/**
 * Saves the SQL data to be altered in a local variable ($savedData)
 */
function Trigger_Default_saveData(&$tNG) {
	return $tNG->saveData();
}

// Login triggers
function Trigger_Login_CheckLogin(&$tNG) {
	// check username
	if (!is_object($tNG->transactionResult)) {
		$errObj = new tNG_error("LOGIN_FAILED", array(), array());
		$errObj->setFieldError("kt_login_user", "LOGIN_INVALID_USERNAME", array());
		return $errObj;
	}
	if ($tNG->transactionResult->RecordCount() > 1) {
		$errObj = new tNG_error("LOGIN_FAILED_MANYRECORDS", array(), array());
		$errObj->setFieldError("kt_login_user", "LOGIN_FAILED_MANYRECORDS_FIELDERR", array());
		return $errObj;
	}

	// check password 
	switch ($tNG->loginType) {
		case 'form':
			$db_password = $tNG->transactionResult->Fields('kt_login_password');
			$password_enc = $tNG->getColumnValue('kt_login_password');
			if ($GLOBALS['tNG_login_config']['password_encrypt'] == "true") {
				$password_enc = tNG_encryptString($password_enc);
			}
			if ($db_password != $password_enc) {
				$errObj = new tNG_error("LOGIN_FAILED", array(), array());
				$errObj->setFieldError("kt_login_password", "LOGIN_INVALID_PASSWORD", array());
				return $errObj;
			}
			break;
		case 'cookie':
			$db_password_enc  = tNG_encryptString($tNG->transactionResult->Fields('kt_login_password'));
			$password_enc_cookie = $tNG->getColumnValue('kt_login_test');
			if ($db_password_enc != $password_enc_cookie) {
				return new tNG_error("LOGIN_FAILED", array(), array());
			}
			break;	
		case 'activation':
			$random_key_trans = $tNG->getColumnValue('kt_login_random');
			$random_key_db = $tNG->transactionResult->Fields($GLOBALS['tNG_login_config']['randomkey_field']);
			if ($random_key_trans != $random_key_db) {
				return new tNG_error("LOGIN_FAILED", array(), array());
			}
			break;
	}
	return null;
}


function Trigger_Login_CheckUserActive(&$tNG) {
	if ($GLOBALS['tNG_login_config']['activation_field']  != "" ) {
		// check activation
		$active_column = $GLOBALS['tNG_login_config']['activation_field'];
		$tmp = $tNG->transactionResult->Fields($active_column);
		if (!isset($tmp)) {
			return new tNG_error("LOGIN_FAILED_NO_ACTIVE_FIELD", array(), array($active_column));
		}
		if ($tNG->transactionResult->Fields($active_column) == 0) {
			$errObj = new tNG_error("LOGIN_INACTIVE_USER", array(), array());
			$errObj->setFieldError("kt_login_user", "LOGIN_INACTIVE_USER_FIELDERR", array());
			return $errObj;
		}	
	}
	return null;
}

function Trigger_Login_AddDynamicFields(&$tNG) {
	// register all the columns from the recordset as transaction columns (to be available later)
	$rs = $tNG->transactionResult;

	$tNG->addColumn("kt_login_id", "STRING_TYPE", "VALUE", $rs->Fields("kt_login_id"));		
	$tNG->addColumn("kt_login_user", "STRING_TYPE", "VALUE", $rs->Fields("kt_login_user"));		
	$tNG->addColumn("kt_login_password_db", "STRING_TYPE", "VALUE", $rs->Fields("kt_login_password"));		
	if ($GLOBALS['tNG_login_config']['level_field'] != "") {
		$tNG->addColumn("kt_login_level", "STRING_TYPE", "VALUE", $rs->Fields($GLOBALS['tNG_login_config']['level_field']));		
	}	
	
	// must add {kt_login_redirect}
	$login_redirect = '';
	switch ($tNG->loginType) {
		case 'form':
		case 'activation':
			$login_redirect = "";
			if (isset($_SESSION['KT_denied_pageuri']) && is_array($_SESSION['KT_denied_pagelevels'])) {
				// if restrict using levels is used
				if ($GLOBALS['tNG_login_config']['level_field'] != "" ) {
					$level_column = $GLOBALS['tNG_login_config']['level_field'];
					$level_value = $tNG->transactionResult->Fields($level_column);
					
					$arr_allowed_levels = $_SESSION['KT_denied_pagelevels'];
					// check if the current user can be redirected to previously denied page
					if (count($arr_allowed_levels) > 0) {
						if (in_array($level_value, $arr_allowed_levels)) {
							$login_redirect = $_SESSION['KT_denied_pageuri'];
						} else {
							// redirect to the denied page will result into another denied page, so don't redirect
						}
					} else {
						// levels array has no elements - acccess is allowed to all logged users
						$login_redirect = $_SESSION['KT_denied_pageuri'];
					}
				} else {
					// no levels restriction is used, so we can redirect to previously denied page
					$login_redirect = $_SESSION['KT_denied_pageuri'];	
				}
				
				unset($_SESSION['KT_denied_pageuri']);
				KT_unsetSessionVar('KT_denied_pageuri');
				unset($_SESSION['KT_denied_pagelevels']);
				KT_unsetSessionVar('KT_denied_pagelevels');
			}
			
			if ($login_redirect == "") {
				$relPath = '';
				if (isset($tNG->dispatcher) && isset($tNG->dispatcher->relPath)) {
					$relPath = KT_makeIncludedURL($tNG->dispatcher->relPath);
				}
				if ($GLOBALS['tNG_login_config']['level_field'] != "" ) {
					$level_column = $GLOBALS['tNG_login_config']['level_field'];
					$level_value = $tNG->transactionResult->Fields($level_column);
					if (is_array($GLOBALS['tNG_login_config_redirect_success']) && isset($GLOBALS['tNG_login_config_redirect_success'][$level_value]) AND $GLOBALS['tNG_login_config_redirect_success'][$level_value] != "") {
						$login_redirect = $relPath. $GLOBALS['tNG_login_config_redirect_success'][$level_value];
					} else {
						$login_redirect = $relPath. $GLOBALS['tNG_login_config']['redirect_success'];
					}
				} else {
					$login_redirect =  $relPath. $GLOBALS['tNG_login_config']['redirect_success'];
				}
			}	
			break;
		case 'cookie':
			// cookie login doesn't use redirect	
	}
	$tNG->addColumn("kt_login_redirect", "STRING_TYPE", "VALUE", $login_redirect);
	return null;
}

function Trigger_Login_SaveDataToSession(&$tNG) {
	// default sessions
	$rs = $tNG->transactionResult;
	
	$_SESSION['kt_login_user'] = $tNG->getColumnValue('kt_login_user');
	KT_setSessionVar('kt_login_user');
	$_SESSION['kt_login_id'] = $tNG->getColumnValue('kt_login_id');
	KT_setSessionVar('kt_login_id');
	if ($GLOBALS['tNG_login_config']['level_field'] != "") {
		$_SESSION['kt_login_level'] = $tNG->getColumnValue("kt_login_level");
		KT_setSessionVar('kt_login_level');
	}
	// user-grid session
	if (is_array($GLOBALS['tNG_login_config_session'])) {
		$ses_arr = $GLOBALS['tNG_login_config_session'];
		foreach ($ses_arr as $ses_name => $ses_value) {
			if ($rs->Fields($ses_value) !== '') {
				$_SESSION[$ses_name] = $rs->Fields($ses_value);
			} else {
				$_SESSION[$ses_name] = $rs->Fields($ses_name);
			}
			KT_setSessionVar($ses_name);
		}
	}
	return null;
}

function Trigger_Login_AutoLogin(&$tNG) {
	$cookie_path = tNG_getRememberMePath();
	if ($tNG->loginType != 'cookie') {
		// unset cookies for any login transaction that is not of type 'cookie'
		if (isset($_SESSION['kt_login_id']) && isset($_SESSION['kt_login_test'])) {
			$cookie_timeout = time() - 3600;
			setcookie("kt_login_id", "", $cookie_timeout, $cookie_path);
			setcookie("kt_login_test", "", $cookie_timeout, $cookie_path);
			unset($_SESSION['kt_login_id']);
			unset($_SESSION['kt_login_test']);
		}	
	}
	if (isset($tNG->columns['kt_login_rememberme']) && $tNG->getColumnValue('kt_login_rememberme')!="") { 
		// for the cookies to use the same valability path as session
		$cookie_timeout = time() + intval($GLOBALS['tNG_login_config']['autologin_expires']) * 24 * 60 * 60;

		setcookie("kt_login_id", $tNG->getColumnValue('kt_login_id'), $cookie_timeout, $cookie_path);

		$kt_test = tNG_encryptString($tNG->getColumnValue('kt_login_password_db'));
		setcookie("kt_login_test", $kt_test,  $cookie_timeout, $cookie_path);
	}
	return null;
}


// Register (Insert) Transaction triggers

//start Trigger_registration_CheckUniqueUsername trigger
//remove this line if you want to edit the code by hand
function Trigger_Registration_CheckUniqueUsername(&$tNG) {
  $tblFldObj = new tNG_CheckUnique($tNG);
  $tblFldObj->setTable($GLOBALS['tNG_login_config']['table']);	
  $tblFldObj->setFieldName($GLOBALS['tNG_login_config']['user_field']);
  $tblFldObj->setErrorMsg(KT_getResource("REGISTRATION_UNIQUE_USER_FIELDERR", "tNG"));
  return $tblFldObj->Execute();
}
//end Trigger_registration_CheckUniqueUsername trigger


function Trigger_Registration_CheckPassword(&$tNG) {
	$password_field = $GLOBALS['tNG_login_config']['password_field'];
	if (!isset($tNG->columns[$password_field])) {
		$password = tNG_generateRandomString(6);
		$tNG->addColumn($password_field, "STRING_TYPE", "VALUE", $password);
	}
	return null;
}

function Trigger_Registration_EncryptPassword(&$tNG) {
	$password_column = $GLOBALS['tNG_login_config']['password_field'];
    $password = $tNG->getColumnValue($password_column);
    $tNG->kt_login_password = $password;
    $tNG->setRawColumnValue($password_column, tNG_encryptString($password));
	return null;
}

function Trigger_Registration_PrepareActivation(&$tNG) {
	if (!isset($tNG->columns[$GLOBALS['tNG_login_config']['activation_field']])) {
		$tNG->addColumn($GLOBALS['tNG_login_config']['activation_field'], "NUMERIC_TYPE", "VALUE", 0);
	}
	if ($GLOBALS['tNG_login_config']['randomkey_field'] != "") {
		$random_key = tNG_generateRandomString(0);
		$tNG->addColumn($GLOBALS['tNG_login_config']['randomkey_field'], "STRING_TYPE", "VALUE", $random_key);
	}
	return null;
 
}

function Trigger_Registration_RestorePassword(&$tNG) {
	$password_field = $GLOBALS['tNG_login_config']['password_field'];
	$tNG->setRawColumnValue($password_field, $tNG->kt_login_password);
	return null;
}

function Trigger_Registration_AddDynamicFields(&$tNG) {
	$user_field = $GLOBALS['tNG_login_config']['user_field'];
	$tNG->addColumn("kt_login_user", "STRING_TYPE", "VALUE", $tNG->getColumnValue($user_field));
	$password_field = $GLOBALS['tNG_login_config']['password_field'];
	$tNG->addColumn("kt_login_password", "STRING_TYPE", "VALUE", $tNG->getColumnValue($password_field));


	if ($GLOBALS['tNG_login_config']['activation_field'] != "" && $GLOBALS['tNG_login_config']['email_field']!="" && isset($tNG->columns[$GLOBALS['tNG_login_config']['email_field']])) {	
		$args = 'kt_login_id='. $tNG->getColumnValue($GLOBALS['tNG_login_config']['pk_field']);
		if ($GLOBALS['tNG_login_config']['randomkey_field'] != "") {
			$args .= '&kt_login_random='. $tNG->getColumnValue($GLOBALS['tNG_login_config']['randomkey_field']);
		} else  {
			$args .= '&kt_login_email='. $tNG->getColumnValue($GLOBALS['tNG_login_config']['email_field']);
		}
		
		$tmpPath = KT_makeIncludedURL("");
		$activation_page = KT_getUriFolder().$tmpPath.'activate.php?'. $args;
		$tNG->addColumn("kt_activation_page", "STRING_TYPE", "VALUE", $activation_page);
	}
	$tmpRelPath = KT_makeIncludedURL($tNG->dispatcher->relPath);
	$login_page = KT_Rel2AbsUrl(KT_getUri(), $tmpRelPath  , $GLOBALS['tNG_login_config']['login_page']);
	$tNG->addColumn("kt_login_page", "STRING_TYPE", "VALUE", $login_page);

	$redirect_page = $tmpRelPath . $GLOBALS['tNG_login_config']['login_page'];
	if ($GLOBALS['tNG_login_config']['email_field']!="" && isset($tNG->columns[$GLOBALS['tNG_login_config']['email_field']])) {	
		if ($GLOBALS['tNG_login_config']['activation_field']!="") {
			if (isset($tNG->columns[$GLOBALS['tNG_login_config']['activation_field']]) && $tNG->getColumnValue($GLOBALS['tNG_login_config']['activation_field']) != 0) {
				$redirect_page = KT_addReplaceParam($redirect_page, "info", "REG");
			} else {
				$redirect_page = KT_addReplaceParam($redirect_page, "info", "REG_ACTIVATE");
			}
		} else {
			$redirect_page = KT_addReplaceParam($redirect_page, "info", "REG_EMAIL");
		}
	}
	else {
		$redirect_page = KT_addReplaceParam($redirect_page, "info", "REG");
	}
	$tNG->addColumn("kt_login_redirect", "STRING_TYPE", "VALUE", $redirect_page);
	return null;
}


// Activation (Update) Transaction triggers
function Trigger_Activation_Check(&$tNG) {
	if ($GLOBALS['tNG_login_config']['activation_field'] == "") {
		return new tNG_error("ACTIVATION_NOT_ENABLED", array(), array());
	}
	if ($GLOBALS['tNG_login_config']['email_field'] == "") {	
		return new tNG_error("ACTIVATION_NO_EMAIL", array(), array());
	}
	if ($tNG->getTable() != $GLOBALS['tNG_login_config']['table']) {
		return new tNG_error("ACTIVATION_WRONG_TABLE", array(), array());
	}
	if ($tNG->getPrimaryKey() != $GLOBALS['tNG_login_config']['pk_field']) {
		return new tNG_error("ACTIVATION_WRONG_PK", array(), array());
	}
	if (!isset($tNG->columns[$GLOBALS['tNG_login_config']['activation_field']])) {
		return new tNG_error("ACTIVATION_NO_ACTIVE_FIELD", array(), array());
	}
	// build the sql string to check 
	if ($GLOBALS['tNG_login_config']['randomkey_field']!="") {
		$random_key = KT_getRealValue("GET","kt_login_random");
		if($random_key=="") {	
			return new tNG_error("ACTIVATION_NO_PARAM_RANDOM", array(), array());
		}
		$random_key = KT_escapeForSql($random_key, "STRING_TYPE");
		$pk_value = KT_escapeForSql($tNG->getPrimaryKeyValue(), $GLOBALS['tNG_login_config']['pk_type']);
		$sql = "SELECT ". KT_escapeFieldName($tNG->getPrimaryKey()) . ", ".  KT_escapeFieldName($GLOBALS['tNG_login_config']['activation_field']) . " FROM " .  $tNG->getTable() . " WHERE " .  KT_escapeFieldName($tNG->getPrimaryKey()) . "=" .  $pk_value . " AND ".  KT_escapeFieldName($GLOBALS['tNG_login_config']['randomkey_field']) . "=" . $random_key ;
		$rs = $tNG->connection->Execute($sql);
		if (!is_object($rs)) {
			return new tNG_error("LOGIN_RECORDSET_ERR", array(), array());
		}
	} else {
		$email_value = KT_getRealValue("GET","kt_login_email");
		if($email_value=="") {
			return new tNG_error("ACTIVATION_NO_PARAM_EMAIL", array(), array());
		}
		$email_value = KT_escapeForSql($email_value, "STRING_TYPE");
		$pk_value = KT_escapeForSql($tNG->getPrimaryKeyValue(), $GLOBALS['tNG_login_config']['pk_type']);
		$sql = "SELECT ".  KT_escapeFieldName($tNG->getPrimaryKey()) . ", ".  KT_escapeFieldName($GLOBALS['tNG_login_config']['activation_field']) . " FROM " .  $tNG->getTable() . " WHERE " .  KT_escapeFieldName($tNG->getPrimaryKey()) . "=" . $pk_value . " AND ".  KT_escapeFieldName($GLOBALS['tNG_login_config']['email_field']) . "=" . $email_value ;
		$rs = $tNG->connection->Execute($sql);
		if (!is_object($rs)) {
			return new tNG_error("LOGIN_RECORDSET_ERR", array(), array());
		}
	}
	if ($rs->RecordCount() == 0 ) {
		return new tNG_error("ACTIVATION_NO_RECORDS", array(), array());
	}
	if ($rs->RecordCount() != 1 ) {
		return new tNG_error("ACTIVATION_TOOMANY_RECORDS", array(), array());
	}
	// check for inactive
	if ($rs->Fields($GLOBALS['tNG_login_config']['activation_field']) != 0) {
		return new tNG_error("ACTIVATION_ALREADY_ACTIVE", array(), array());
	}
	// register the AFTER trigger
	$tNG->registerTrigger("AFTER", "Trigger_Activation_Login", -1);
	return null;
}


function Trigger_Activation_Login(&$tNG) {
	$relPath = KT_makeIncludedURL($tNG->dispatcher->relPath);
	if ($GLOBALS['tNG_login_config']['randomkey_field']!="") {
		$redirect_page = tNG_activationLogin($tNG->connection);
		if ($redirect_page == "") {
			$redirect_page = $relPath . $GLOBALS['tNG_login_config']['login_page'];	
		} else {
			$redirect_page = $relPath .$redirect_page;
		}
	} else {
		$redirect_page = KT_addReplaceParam($relPath. $GLOBALS['tNG_login_config']['login_page'], "info", "ACTIVATED");
	}
	$tNG->addColumn("kt_login_redirect", "STRING_TYPE", "VALUE", $redirect_page);
	return null;
}

// Forgot Password (Update) Transaction triggers
function Trigger_ForgotPassword_CheckEmail(&$tNG) {
	if ($GLOBALS['tNG_login_config']['email_field'] == "") {
		return new tNG_error("FORGOTPASS_NO_EMAIL", array(), array());
	}
	if ($tNG->getTable() != $GLOBALS['tNG_login_config']['table']) {
		return new tNG_error("FORGOTPASS_WRONG_TABLE", array(), array());
	}
	if ($tNG->getPrimaryKey() != $GLOBALS['tNG_login_config']['email_field']) {
		return new tNG_error("FORGOTPASS_WRONG_PK", array(), array());
	}		


	$email_field = $GLOBALS['tNG_login_config']['email_field'];
	$pk_field = $GLOBALS['tNG_login_config']['pk_field'];
	$user_field = $GLOBALS['tNG_login_config']['user_field'];
	$password_field = $GLOBALS['tNG_login_config']['password_field'];
	$table = $GLOBALS['tNG_login_config']['table'];
	
	$email_value = $tNG->getColumnValue ($GLOBALS['tNG_login_config']['email_field']);
	$email_value = KT_escapeForSql($email_value, "STRING_TYPE");
		
	$sql = "SELECT * FROM " .  $table . " WHERE ".  KT_escapeFieldName($email_field) . "=" . $email_value;
	$rs = $tNG->connection->Execute($sql);
	if (!is_object($rs)) {
		return new tNG_error("LOGIN_RECORDSET_ERR", array(), array());
	}
	if ($rs->RecordCount() == 0 ) {
		$errObj = new tNG_error("FORGOTPASS_WRONG_EMAIL", array(), array());
		$errObj->setFieldError($email_field, "FORGOTPASS_WRONG_EMAIL_FIELDERR", array());
		return $errObj;		
	}
	if ($rs->RecordCount() != 1 ) {
		$errObj = new tNG_error("FORGOTPASS_TOOMANY_RECORDS", array(), array());
		$errObj->setFieldError($email_field, "FORGOTPASS_TOOMANY_RECORDS_FIELDERR", array());
		return $errObj;
	}
	
	if ($GLOBALS['tNG_login_config']['activation_field']!="") {
		if ($rs->Fields($GLOBALS['tNG_login_config']['activation_field']) == 0) {
			return new tNG_error("FORGOTPASS_INACTIVE_USER", array(), array());
		}
	}
	$tNG->kt_login_user = $rs->Fields($user_field);
	if ($GLOBALS['tNG_login_config']['password_encrypt'] == "true") {
		$tNG->kt_login_password = tNG_generateRandomString(6);
		$tNG->kt_login_password_enc = tNG_encryptString($tNG->kt_login_password);
	}
	else {
		 $tNG->kt_login_password = $rs->Fields($password_field);
		 $tNG->kt_login_password_enc = $tNG->kt_login_password; // the same values - plain
	}
	$tNG->addColumn($password_field, "STRING_TYPE", "VALUE", $tNG->kt_login_password_enc);
	$tNG->registerTrigger("AFTER", "Trigger_ForgotPassword_AddDynamicFields", -1);
	return null;
}

function Trigger_ForgotPassword_AddDynamicFields(&$tNG) {
	$tNG->addColumn("kt_login_user", "STRING_TYPE", "VALUE", $tNG->kt_login_user);
	$tNG->addColumn("kt_login_password", "STRING_TYPE", "VALUE", $tNG->kt_login_password);

	$tmpRelPath = KT_makeIncludedURL($tNG->dispatcher->relPath);
	$login_page = KT_Rel2AbsUrl(KT_getUri(), $tmpRelPath , $GLOBALS['tNG_login_config']['login_page']);
	$tNG->addColumn("kt_login_page", "STRING_TYPE", "VALUE", $login_page);
	
	$redirect_page = KT_addReplaceParam($tmpRelPath . $GLOBALS['tNG_login_config']['login_page'], "info", "FORGOT");
	$tNG->addColumn("kt_login_redirect", "STRING_TYPE", "VALUE", $redirect_page);
	$tNG->registerTrigger("ERROR", "Trigger_ForgotPassword_RemoveDynamicFields", -100);

	return null;
}

function Trigger_ForgotPassword_RemoveDynamicFields(&$tNG) {
	if (isset($tNG->columns["kt_login_user"])) {
		unset($tNG->columns["kt_login_user"]);
	}
	if (isset($tNG->columns["kt_login_password"])) {
		unset($tNG->columns["kt_login_password"]);
	}
	if (isset($tNG->columns["kt_login_page"])) {
		unset($tNG->columns["kt_login_page"]);
	}
	if (isset($tNG->columns["kt_login_redirect"])) {
		unset($tNG->columns["kt_login_redirect"]);
	}
	return null;
}

// Update User Table Transaction triggers
function Trigger_UpdatePassword_CheckOldPassword(&$tNG) {
	$password_field = $GLOBALS['tNG_login_config']['password_field'];
	$password_value = $tNG->getColumnValue ($password_field);
	$old_password_value =  KT_DynamicData("{POST.old_" . $password_field."}",$tNG);
	
	if ($old_password_value != "" && $password_value == "") {
		$errObj = new tNG_error("UPDATEPASS_NO_NEW_PASS", array(), array());
		$errObj->setFieldError($password_field, "UPDATEPASS_NO_NEW_PASS_FIELDERR", array());
		return $errObj;		
	}
	
	if ($password_value != "") { 
		if ($GLOBALS['tNG_login_config']['password_encrypt'] == "true") {
			if ($old_password_value != "") {
				$old_password_value = tNG_encryptString($old_password_value);
			}
		}
		$table = $GLOBALS['tNG_login_config']['table'];
		$pk_field = $GLOBALS['tNG_login_config']['pk_field'];
		$pk_value = KT_escapeForSql($tNG->getPrimaryKeyValue(), $GLOBALS['tNG_login_config']['pk_type']);
		
		$sql = "SELECT " . KT_escapeFieldName($password_field). " FROM " .  $table . " WHERE ".  KT_escapeFieldName($pk_field) . "=" . $pk_value;
		$rs = $tNG->connection->Execute($sql);
		
		if (!is_object($rs)) {
			return new tNG_error("LOGIN_RECORDSET_ERR", array(), array());
		}
		if ($rs->RecordCount() == 0 ) {
			return new tNG_error("UPDATEPASS_NO_RECORD", array(), array());
		}
		if ($rs->RecordCount() != 1 ) {
			return new tNG_error("UPDATEPASS_TOMANY_RECORDS", array(), array());
		}
		
		$db_password_value = $rs->Fields($GLOBALS['tNG_login_config']['password_field']);
		if ($db_password_value != $old_password_value) {
			$tNG->addColumn("old_" . $password_field, "STRING_TYPE", "VALUE", "");
			$errObj = new tNG_error("UPDATEPASS_WRONG_OLD_PASS", array(), array());
			$errObj->setFieldError("old_" .$password_field, "UPDATEPASS_WRONG_OLD_PASS_FIELDERR", array());
			return $errObj;
		}
	}
	return null;
}


function Trigger_UpdatePassword_EncryptPassword(&$tNG) {
	if ($GLOBALS['tNG_login_config']['password_encrypt'] == "true") { // this is a double check
		$password_column = $GLOBALS['tNG_login_config']['password_field'];
		$password = $tNG->getColumnValue($password_column);
		if ($password != "" ) {
			$tNG->kt_login_password = $password;
			$tNG->setRawColumnValue($password_column, tNG_encryptString($password));
		}	
	}
	return null;
}

function Trigger_UpdatePassword_RemovePassword(&$tNG) {
	$password_column = $GLOBALS['tNG_login_config']['password_field'];
    $password = $tNG->getColumnValue($password_column);
	if ($password == "" ) {
		// removes the password from the array
		$tNG->KT_password_column = $tNG->columns[$password_column];	
		unset ($tNG->columns[$password_column]);
	}
	return null;
}

function Trigger_UpdatePassword_AddPassword(&$tNG) {
	if (isset($tNG->KT_password_column)) {  // only if the password has been removed
		$password_column = $GLOBALS['tNG_login_config']['password_field'];
		$tNG->columns[$password_column] = $tNG->KT_password_column;	
	}	
	return null;
}

function Trigger_UpdatePassword_RestorePassword(&$tNG) {
	if ($GLOBALS['tNG_login_config']['password_encrypt'] == "true") { // this is a double check
		$password_column = $GLOBALS['tNG_login_config']['password_field'];
		$password = $tNG->getColumnValue($password_column);
		if ($password != "" ) {
			$password = $tNG->kt_login_password;
			$tNG->setRawColumnValue($password_column, $password);
		}	
	}
	return null;
}

function Trigger_UpdatePassword_RemoveOldPassword(&$tNG) {
	$password_field = $GLOBALS['tNG_login_config']['password_field'];
	if (isset($tNG->columns['old_' . $password_field])) {
		unset($tNG->columns['old_' . $password_field]);
	}
	return null;
}

function Trigger_Update_RefreshSession(&$tNG) {
	if (is_array($GLOBALS['tNG_login_config_session'])) {
		KT_session_start();
		if (isset($_SESSION['kt_login_id'])) {
			$session_pk_field = $GLOBALS['tNG_login_config_session']['kt_login_id'];
			$session_pk_value = $_SESSION['kt_login_id'];
			$pk_field = $tNG->getPrimaryKey();
			$pk_value = $tNG->getPrimaryKeyValue();
			
			if ($pk_field != '' && $session_pk_field == $pk_field && $pk_value != '' && $session_pk_value == $pk_value) {
				$ses_arr = $GLOBALS['tNG_login_config_session'];
				foreach ($ses_arr as $ses_name => $ses_value) {
					if ( isset($tNG->columns[$ses_value]) ) {
						$value = $tNG->getColumnValue($ses_value);
						$_SESSION[$ses_name] = $value;
						KT_setSessionVar($ses_name);
					}
				}
			}
		}
	}
	return null;
}

function Trigger_CSVImport_FileUpload(&$tNG, $formFieldName) {
	$ret = null;
	if ($tNG->isStarted()) {
		$uploadObj = new tNG_FileUpload($tNG);
		$uploadObj->setFormFieldName($formFieldName);
		$uploadObj->setDbFieldName('');
		$uploadObj->setFolder(dirname(realpath(__FILE__)).'/../../csv/tmp/');
		$uploadObj->setMaxSize(10000);
		$uploadObj->setAllowedExtensions('txt,csv');
		$uploadObj->setRename("auto");
		$ret = $uploadObj->Execute();
	} else {
		$ret = null;
	}
	return $ret;
}

?>