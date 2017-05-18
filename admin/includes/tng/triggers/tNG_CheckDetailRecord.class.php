<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_CheckDetailRecord extends tNG_CheckTableField {

		function tNG_CheckDetailRecord(&$tNG) {
			parent::tNG_CheckTableField($tNG);
		}

		function Execute() {
			$this->setFieldType($this->tNG->getColumnType($this->tNG->getPrimaryKey()));
			$this->setFieldValue($this->tNG->getPrimaryKeyValue());
			$this->errorIfExists(true);
			$err = parent::Execute();
			if ($err != NULL) {
				// change the default error message
				$useSavedData = false;
				if (in_array($this->tNG->transactionType, array('_delete', '_multipleDelete'))) {
					$useSavedData = true;
				}				
				$this->errorMsg = KT_DynamicData($this->errorMsg, $this->tNG, '', $useSavedData);
				
				// set only user message
				$err = new tNG_error('TRIGGER_MESSAGE__CHECK_DETAIL_RECORD', array(), array());
				$err->addDetails('%s', array($this->errorMsg), array(''));				
			}
			return $err;
		}
	}

?>