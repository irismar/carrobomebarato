<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

class tNG_ManyToMany{
	var $tNG;
	var $table;
	var $pkName;
	var $fkName;
	var $fkReference;
	/* presupunem ca
		cimpurile din tabela mtm au acelasi tip cu pk-ul
		foreign-key-ul din mtm catre tabela curenta e chiar pk-ul
		metoda e POST
	*/

	function tNG_ManyToMany(&$tNG) {
		$this->tNG = &$tNG;
		$this->table = '';
		$this->pkName = '';
		$this->fkName = '';
		$this->fkReference = '';
	}

	function setTable($table){
		$this->table = trim($table);
	}

	function setPkName($pkName){
		$this->pkName = trim($pkName);
	}

	function setFkName($fkName){
		$this->fkName = trim($fkName);
	}

	function setFkReference($fkReference){
		$this->fkReference = trim($fkReference);
	}

	function getValues() {
		$values = array();
		
		$fkReference = $this->fkReference;
		$idxReference = "";
		if (isset($this->tNG->multipleIdx)) {
			$idxReference = '_' . $this->tNG->multipleIdx;
			$idxReference = preg_quote($idxReference, '/');
		}
		$fkReference = preg_quote($fkReference, '/');
		$keys = array_keys($_POST);
		foreach ($keys as $idx => $key) {
			if (preg_match('/^' . $fkReference . '_(\d+)'.$idxReference.'$/', $key, $matches)) {
				array_push($values, $matches[1]);
			}
		}
		return $values;
	}

	function getOldValues() {
		$ret = array();
		$pk_value = $this->tNG->getPrimaryKeyValue();
		$pk_type = $this->tNG->getColumnType($this->tNG->getPrimaryKey());
		$pk_value = KT_escapeForSql($pk_value, $pk_type);
		$sql = "SELECT ".KT_escapeFieldName($this->fkName)." FROM " . $this->table . " WHERE " . KT_escapeFieldName($this->pkName) . " = " . $pk_value;
		$rs = $this->tNG->connection->Execute($sql);
		if ($rs === false) {
			return new tNG_error('TRIGGER_MESSAGE__MTM_SQL_ERROR', array(), array($this->tNG->connection->ErrorMsg(), $sql));
		}
		while (!$rs->EOF) {
			$ret[] = $rs->Fields($this->fkName);
			$rs->MoveNext();
		}
		return $ret;
	}

	function Execute() {
		if ($this->fkReference == '') {
			return new tNG_error('TRIGGER_MESSAGE__MTM_NO_REFERENCE', array(), array());
		}
		$pk_value = $this->tNG->getPrimaryKeyValue();
		$pk_type = $this->tNG->getColumnType($this->tNG->getPrimaryKey());
		$pk_value = KT_escapeForSql($pk_value, $pk_type);
		
		$values = $this->getValues();
		$oldValues = $this->getOldValues();
		if (is_object($oldValues)) {// Returned error message
			return $oldValues;
		}
		if (count($oldValues) >0) {
			$deleteValues = array_diff($oldValues, $values);
			if (count($deleteValues) >0) {
				$in_sql = "";
				foreach ($deleteValues as $key => $value) {
					if ($in_sql != '') {
						$in_sql .= ",";
					}
					$in_sql .= KT_escapeForSql($value,$pk_type);
				}
				$sql = "DELETE FROM " . $this->table . " WHERE " . KT_escapeFieldName($this->pkName) . " = " . $pk_value." AND ".KT_escapeFieldName($this->fkName)." IN (".$in_sql.")";
				$this->tNG->connection->Execute($sql);
			}
		}
		
		if (count($values)>0) {
			$insertValues = array_diff($values,$oldValues);
			if (count($insertValues) >0) {
				foreach ($insertValues as $key => $value) {
					$value = KT_escapeForSql($value, $pk_type);
					$sql = "INSERT INTO " . $this->table . " ( " . KT_escapeFieldName($this->pkName) . " , " . KT_escapeFieldName($this->fkName) . ") VALUES (" . $pk_value . " , " . $value . ")";
					$ret = $this->tNG->connection->Execute($sql);
					if ($ret === false) {
						return new tNG_error('TRIGGER_MESSAGE__MTM_SQL_ERROR', array(), array($this->tNG->connection->ErrorMsg(), $sql));
					}
				}
			}
		}
		return null;
	}
}
?>