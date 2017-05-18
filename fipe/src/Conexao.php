<?php
/**
 * @author Deivid Fortuna <deividfortuna@gmail.com>
 * @version 1.0.0
 *
 * Você pode reportar problemas nesse código no endereço: https://github.com/deividfortuna/fipe/issues
 *
 */
class Conexao
{
	private static $instance;
	private static $user = "root";
	private static $pass = "";
	private static $database = "u386698969_carro";
	private static $host = "localhost";
	
    static public function getInstance()
    {
        if (!isset(self::$instance)) {
        	self::$instance = new \PDO('mysql:host=' . self::$host . ';dbname=' . self::$database, self::$user, self::$pass);
        	self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	self::$instance->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_EMPTY_STRING); 
        } 
        return self::$instance;
    }
}
