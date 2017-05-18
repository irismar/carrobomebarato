<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_CheckMasterRecord extends tNG_CheckTableField {
		var $fkField = '';
		function tNG_CheckMasterRecord(&$tNG) {
			parent::tNG_CheckTableField($tNG);
		}

		function setFkFieldName($field) {
			$this->fkField = $field;
			$this->setFieldType($this->tNG->getColumnType($field));
			$this->setFieldValue($this->tNG->getColumnValue($field));
		}

		function Execute() {
			$this->errorIfExists(false);
			$err = parent::Execute();
			if ($err != NULL) {
				$useSavedData = false;
				if (in_array($this->tNG->transactionType, array('_delete', '_multipleDelete'))) {
					$useSavedData = true;
				}
				$this->errorMsg = KT_DynamicData($this->errorMsg, $this->tNG, '', $useSavedData);
				
				$err = new tNG_error('TRIGGER_MESSAGE__CHECK_MASTER_RECORD', array(), array());
				if ($this->fkField != '') {
					// set field error to $this->errorMsg
					$err->setFieldError($this->fkField, '%s', array($this->errorMsg));
					if ($this->tNG->columns[$this->fkField]['method'] != 'POST') {
						// set composed message as user error
						$err->addDetails('%s', array($this->errorMsg), array(''));
					}
				} else {
					// set composed message as user error
					$err->addDetails('%s', array($this->errorMsg), array(''));
				}
			}
			return $err;
		}
	}
?>