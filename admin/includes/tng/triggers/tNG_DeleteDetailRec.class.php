<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_DeleteDetailRec {
		var $tNG;
		var $table;
		var $field;

		function tNG_DeleteDetailRec(&$tNG) {
			$this->tNG = &$tNG;
			$this->table = 'mytable';
			$this->field = 'myfield';
		}

		function setTable($table) {
			$this->table = $table;
		}

		function setFieldName($field) {
			$this->field = $field;
		}

		function Execute() {
			$pk_value = $this->tNG->getPrimaryKeyValue();
			$pk_type = $this->tNG->getColumnType($this->tNG->getPrimaryKey());
			$pk_value = KT_escapeForSql($pk_value, $pk_type);
			$sql = "DELETE FROM " . $this->table . " WHERE " . KT_escapeFieldName($this->field) . " = " . $pk_value;
			$ret = $this->tNG->connection->Execute($sql);
			if ($ret === false) {
				return new tNG_error('DEL_DR_SQL_ERROR', array(), array($this->tNG->connection->ErrorMsg(), $sql));
			}
			return null;
		}
	}
?>