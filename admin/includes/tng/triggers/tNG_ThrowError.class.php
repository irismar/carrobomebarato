<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_ThrowError {
		var $tNG;
		var $errorMsg;
		var $fieldErrorMsg;
		var $field;

		function tNG_ThrowError(&$tNG) {
			$this->tNG = &$tNG;
			$this->errorMsg = '';
			$this->field = '';
			$this->fieldErrorMsg = '';
		}

		function setErrorMsg($errorMsg) {
			$this->errorMsg = $errorMsg;
		}

		function setFieldErrorMsg($fieldErrorMsg) {
			$this->fieldErrorMsg = $fieldErrorMsg;
		}

		function setField($field) {
			$this->field = $field;
		}

		function Execute() {
			$useSavedData = false;
			if (in_array($this->tNG->transactionType, array('_delete', '_multipleDelete'))) {
				$useSavedData = true;
			}

			$this->errorMsg = KT_DynamicData($this->errorMsg, $this->tNG, '', $useSavedData);
			$this->fieldErrorMsg = KT_DynamicData($this->fieldErrorMsg, $this->tNG, '', $useSavedData);

			$err = new tNG_error('%s', array($this->errorMsg), array(''));
			if (isset($this->tNG->columns[$this->field])) {
				// set field error to $this->errorMsg
				$err->setFieldError($this->field, '%s', array($this->fieldErrorMsg));
				if ($this->tNG->columns[$this->field]['method'] != 'POST') {
					// set composed message as user error
					$err->addDetails('%s', array($this->fieldErrorMsg), array(''));
				}
			} else {
				// set composed message as user error
				$err->addDetails('%s', array($this->fieldErrorMsg), array(''));
			}
			return $err;
		}
	}
?>