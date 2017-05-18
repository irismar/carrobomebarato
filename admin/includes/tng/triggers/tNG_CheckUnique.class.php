<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_CheckUnique extends tNG_CheckTableField {

		function tNG_CheckUnique(&$tNG) {
			parent::tNG_CheckTableField($tNG);
		}

		function Execute() {
			$this->type = $this->tNG->getColumnType($this->field);
			$this->value = $this->tNG->getColumnValue($this->field);
			
			$field_value = KT_escapeForSql($this->value, $this->type);
			$sql = "SELECT " . KT_escapeFieldName($this->field) . " FROM " . $this->table . " WHERE " . KT_escapeFieldName($this->field) . " = " . $field_value;
			if (in_array($this->tNG->transactionType, array('_update', '_multipleUpdate'))) {
				$pk = $this->tNG->getPrimaryKey();
				$pk_value = $this->tNG->getPrimaryKeyValue();
				$pk_type = $this->tNG->getColumnType($this->tNG->getPrimaryKey());
				$pk_value = KT_escapeForSql($pk_value, $pk_type);
				$sql .= " AND " . $pk . " <> " . $pk_value;
			}
			$ret = $this->tNG->connection->Execute($sql);
			if ($ret === false) {
				return new tNG_error('CHECK_TF_SQL_ERROR', array(), array($this->tNG->connection->ErrorMsg(), $sql));
			}
			if (!$ret->EOF) {
				$useSavedData = false;
				if (in_array($this->tNG->transactionType, array('_delete', '_multipleDelete'))) {
					$useSavedData = true;
				}
				$this->errorMsg = KT_DynamicData($this->errorMsg, $this->tNG, '', $useSavedData);
				$err = new tNG_error('TRIGGER_MESSAGE__CHECK_UNIQUE', array($this->field), array());
				if (isset($this->tNG->columns[$this->field])) {
					// set field error to $this->errorMsg
					$err->setFieldError($this->field, '%s', array($this->errorMsg));
					if ($this->tNG->columns[$this->field]['method'] != 'POST') {
						// set composed message as user error
						$err->addDetails('%s', array($this->errorMsg), array(''));
					}
				} else {
					// set composed message as user error
					$err->addDetails('%s', array($this->errorMsg), array(''));
				}
				return $err;
			}
			return null;
		}
	}

?>