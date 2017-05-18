<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_CheckTableField {
		var $tNG;
		var $table;
		var $field;
		var $type;
		var $value;
		var $errorMsg;

		function tNG_CheckTableField(&$tNG) {
			$this->tNG = &$tNG;
			$this->table = 'mytable';
			$this->field = 'myfield';
			$this->type = 'NUMERIC_TYPE';
			$this->value = -1;
			$this->errorMsg = '';
			$errorIfExists = false;
		}

		function setTable($table) {
			$this->table = $table;
		}

		function setFieldName($field) {
			$this->field = $field;
		}

		function setFieldType($type) {
			$this->type = $type;
		}

		function setFieldValue($value) {
			$this->value = $value;
		}

		function errorIfExists($throwErrorIfExists) {
			$this->throwErrorIfExists = $throwErrorIfExists;
		}

		function setErrorMsg($errorMsg) {
			$this->errorMsg = $errorMsg;
		}
		
		function Execute() {
			$field_value = KT_escapeForSql($this->value, $this->type);
			$sql = "SELECT " . KT_escapeFieldName($this->field) . " FROM " . $this->table . " WHERE " . KT_escapeFieldName($this->field) . " = " . $field_value;
			$ret = $this->tNG->connection->Execute($sql);
			if ($ret === false) {
				return new tNG_error('CHECK_TF_SQL_ERROR', array(), array($this->tNG->connection->ErrorMsg(), $sql));
			}
			$useSavedData = false;
			if (in_array($this->tNG->transactionType, array('_delete', '_multipleDelete'))) {
				$useSavedData = true;
			}
			
			if ($this->throwErrorIfExists && !$ret->EOF) {
				$err = new tNG_error('DEFAULT_TRIGGER_MESSAGE', array(), array());
				return $err;
			}
			if (!$this->throwErrorIfExists && $ret->EOF) {
				$err = new tNG_error('DEFAULT_TRIGGER_MESSAGE', array(), array());
				return $err;
			}
			return null;
		}
	}
?>