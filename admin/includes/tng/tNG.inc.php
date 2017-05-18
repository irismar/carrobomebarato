<?php
/*
	Copyright (c) InterAKT Online 2000-2004
*/

	$KT_tNG_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_tNG_uploadFileList1 = array(
		'tNG_config.inc.php',
		'../common/KT_common.php',
		'tNG_functions.inc.php',
		'triggers/tNG_defTrigg.inc.php',
		'../common/lib/resources/KT_Resources.php',
		'../common/lib/shell/KT_Shell.php',
		'../common/lib/folder/KT_Folder.php',
		'../common/lib/file_upload/KT_FileUpload.php',
		'../common/lib/image/KT_Image.php',
		'../common/lib/email/KT_Email.php',
		'../common/lib/db/KT_Db.php',
		'../common/KT_functions.inc.php',
	);

	$KT_tNG_uploadFileList2 = array(
		'tNG_log.class.php',
		'tNG_dispatcher.class.php',
		'tNG.class.php',
		'tNG_fields.class.php',
		'tNG_insert.class.php',
		'tNG_update.class.php',
		'tNG_delete.class.php',
		'tNG_multiple.class.php',
		'tNG_custom.class.php',
		'tNG_error.class.php',
		'triggers/tNG_Redirect.class.php',
		'triggers/tNG_FormValidation.class.php',
		'triggers/tNG_FileUpload.class.php',
		'triggers/tNG_ImageUpload.class.php',
		'triggers/tNG_FileDelete.class.php',
		'triggers/tNG_LinkedTrans.class.php',
		'triggers/tNG_CheckTableField.class.php',
		'triggers/tNG_CheckUnique.class.php',
		'triggers/tNG_CheckDetailRecord.class.php',
		'triggers/tNG_CheckMasterRecord.class.php',
		'triggers/tNG_DeleteDetailRec.class.php',
		'triggers/tNG_ThrowError.class.php',
		'triggers/tNG_ManyToMany.class.php',
	);

	for ($KT_tNG_i=0;$KT_tNG_i<sizeof($KT_tNG_uploadFileList1);$KT_tNG_i++) {
		$KT_tNG_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_tNG_uploadFileList1[$KT_tNG_i];
		if (file_exists($KT_tNG_uploadFileName)) {
			require_once($KT_tNG_uploadFileName);
		} else {
			die(sprintf($KT_tNG_uploadErrorMsg,$KT_tNG_uploadFileList1[$KT_tNG_i]));
		}
	}

	for ($KT_tNG_i=0;$KT_tNG_i<sizeof($KT_tNG_uploadFileList2);$KT_tNG_i++) {
		$KT_tNG_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_tNG_uploadFileList2[$KT_tNG_i];
		if (file_exists($KT_tNG_uploadFileName)) {
			if (substr(PHP_VERSION, 0, 1) != '5') {
				require_once($KT_tNG_uploadFileName);
			}
		} else {
			die(sprintf($KT_tNG_uploadErrorMsg,$KT_tNG_uploadFileList2[$KT_tNG_i]));
		}
	}

	function __autoload($class_name) {
		$arr = array(
			'tNG_log' => 'tNG_log.class.php',
			'tNG_dispatcher' => 'tNG_dispatcher.class.php',
			'tNG' => 'tNG.class.php',
			'tNG_fields' => 'tNG_fields.class.php',
			'tNG_insert' => 'tNG_insert.class.php',
			'tNG_update' => 'tNG_update.class.php',
			'tNG_delete' => 'tNG_delete.class.php',
			'tNG_multiple' => 'tNG_multiple.class.php',
			'tNG_multipleInsert' => 'tNG_multipleInsert.class.php',
			'tNG_multipleUpdate' => 'tNG_multipleUpdate.class.php',
			'tNG_multipleDelete' => 'tNG_multipleDelete.class.php',
			'tNG_custom' => 'tNG_custom.class.php',
			'tNG_login' => 'tNG_login.class.php',
			'tNG_CSVImport' => 'tNG_CSVImport.class.php',
			'tNG_error' => 'tNG_error.class.php',
			'tNG_SetOrderField' => 'triggers/tNG_SetOrderField.class.php',
			'tNG_Redirect' => 'triggers/tNG_Redirect.class.php',
			'tNG_FormValidation' => 'triggers/tNG_FormValidation.class.php',
			'tNG_FileUpload' => 'triggers/tNG_FileUpload.class.php',
			'tNG_ImageUpload' => 'triggers/tNG_ImageUpload.class.php',
			'tNG_FileDelete' => 'triggers/tNG_FileDelete.class.php',
			'tNG_LinkedTrans' => 'triggers/tNG_LinkedTrans.class.php',
			'tNG_CheckTableField' => 'triggers/tNG_CheckTableField.class.php',
			'tNG_CheckUnique' => 'triggers/tNG_CheckUnique.class.php',
			'tNG_CheckDetailRecord' => 'triggers/tNG_CheckDetailRecord.class.php',
			'tNG_CheckMasterRecord' => 'triggers/tNG_CheckMasterRecord.class.php',
			'tNG_DeleteDetailRec' => 'triggers/tNG_DeleteDetailRec.class.php',
			'tNG_ThrowError' => 'triggers/tNG_ThrowError.class.php',
			'tNG_Email' => 'triggers/tNG_Email.class.php',
			'tNG_EmailRecordset' => 'triggers/tNG_EmailRecordset.class.php',
			'tNG_EmailPageSection' => 'triggers/tNG_EmailPageSection.class.php',
			'tNG_RestrictAccess' => 'triggers/tNG_RestrictAccess.class.php',
			'tNG_Logout' => 'triggers/tNG_Logout.class.php',
			'tNG_UserLoggedIn' => 'triggers/tNG_UserLoggedIn.class.php',
			'tNG_ManyToMany' => 'triggers/tNG_ManyToMany.class.php'
		);

		if (isset($arr[$class_name])) {
		   require_once(dirname(realpath(__FILE__)). '/' . $arr[$class_name]);
		}
	}


//set SERVER variables from ENV if is CGI/FAST CGI
KT_setServerVariables();
//start the session
KT_session_start();
?>
