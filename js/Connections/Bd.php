<?php
//------Script desenvolvido por Lucas Francisco da Matta Vegi. 15/08/2009------
class banco_dados
{	
	public function __construct()
	{

	}

	/************** Fun��o para conectar com o banco **************/
	public function conecta($endereco,$user,$pass,$nome_bd)
	{
		$conexao = mysql_connect("$endereco", "$user", "$pass");
 		mysql_select_db("$nome_bd");
 		
 		return $conexao;
	}

	/************** Fun��o para desconectar com o banco **************/
	public function desconecta()
	{
		$desconexao = mysql_close();
		
		return $desconexao;
	}

	/************** Fun��o de pesquisa em tabelas do banco de dados **************/
 	public function seleciona ($Tabela, $Campos, $Restricao, $Ordem )
 	{
   		if ($Restricao == "")
   		{
     		$Sentenca_sql = "select ".$Campos." from ".$Tabela." ".$Ordem;
   		}
   		else
   		{
     		$Sentenca_sql = "select ".$Campos." from ".$Tabela." where ".$Restricao." ".$Ordem;
   		}
   			$Query = mysql_query($Sentenca_sql);
   			return $Query;
  	}

	/************** Fun��o de inser��o de dados em tabelas do banco **************/
 	public function insere ($Tabela, $Campos, $Valores)
 	{
   		$Sentenca_sql = "insert into ".$Tabela."(".$Campos.")"." values(".$Valores.")";
   		$Query = mysql_query($Sentenca_sql);
   		return $Query;
 	}

 	/************** Fun��o de remo��o de dados em tabelas do banco **************/
 	public function remove ($Tabela, $Restricao)
 	{
	
		$Sentenca_sql = "delete from ".$Tabela." where ".$Restricao;
		$Query = mysql_query($Sentenca_sql);
		return $Query;
 	}

  	/************** Fun��o de altera��o de dados em tabelas do banco **************/
 	public function altera ($Tabela, $Campo, $Valor ,$Restricao)
 	{
	
		$Sentenca_sql = "update ".$Tabela." set ".$Campo." = ".$Valor." where ".$Restricao;
		$Query = mysql_query($Sentenca_sql);
		return $Query;
 	}
}
?>