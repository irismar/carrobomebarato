<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	/**
	 * The connection class
	 */
	class KT_Connection {

		/**
		 * The database name
		 * @var string
		 * @access private
		 */
		var $databaseName = '';

		/**
		 * The connection Resource ID
		 * @var object ResourceID
		 * @access private
		 */
		var $connection = null;
		
		var $servermodel = "mysql";
		
		/**
		 * for ADODB compatibility
		 */
		var $databaseType = "mysql";

		/**
		 * The constructor
		 * Sets the connection and the database name
		 * @param object ResourceID &$connection
		 * @param string $databasename
		 * @access public
		 */
		function KT_Connection(&$connection, $databasename) {
			$this->connection = &$connection;
			$this->databaseName = $databasename;
		}

		/**
		 * Executes a SQL statement
		 * @param string $sql
		 * @return object unknown
		 *         true on success
		 *         response Resource ID if one is returned by the wrapper function
		 * @access public
		 */
		function Execute($sql) {
			mysql_select_db($this->databaseName, $this->connection);
			$response = mysql_query($sql, $this->connection);
			if (!is_resource($response)) {
				return $response;
			} else {
				$recordset = new KT_Recordset($response);
				return $recordset;
			}
		}

		/**
		 * Executes a SQL statement
		 * @param string $sql
		 * @return mysql resource
		 *         true on success
		 *         response MYSQL Resource ID
		 * @access public
		 */
		function MySQL_Execute($sql) {
			mysql_select_db($this->databaseName, $this->connection);
			$response = mysql_query($sql, $this->connection);
			return $response;
		}

		/**
		 * Gets the error message
		 * @return string
		 * @access public
		 */
		function ErrorMsg() {
			return mysql_error($this->connection);
		}

		/**
		 * Gets the auto-generated inserted id (if any)
		 * @return object unknown
		 * @access public
		 */
		function Insert_ID($table, $pKeyCol) {
			return mysql_insert_id($this->connection);
		}
	}
?>