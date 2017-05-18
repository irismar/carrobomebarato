<?php

class conexao
{

    /*
        Altere as variaveis a seguir caso necessario
    */

    private $db_host = 'localhost'; // servidor
    private $db_user = 'root'; // usuario do banco
    private $db_pass = ''; // senha do usuario do banco
    private $db_name = 'u386698969_carro'; // nome do banco

    private $con = false;

  
    public function connect() // estabelece conexao
    {
        if(!$this->con)
        {
            $myconn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($myconn)
            {
                $seldb = @mysql_select_db($this->db_name,$myconn);
                if($seldb)
                {
                    $this->con = true;
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }

  
    public function disconnect() // fecha conexao
    {
    if($this->con)
    {
        if(@mysql_close())
        {
                        $this->con = false;
            return true;
        }
        else
        {
            return false;
        }
    }
    }
     
}
function difereca_data($data1,$data2){
 

$diferenca = strtotime($data2) - strtotime($data1);


    return $dias = floor($diferenca / (60 * 60 * 24));



    
}
function data_pt($date){
    $date_pt=date("d/m/Y ",strtotime($date));
    return $date_pt;
}

function data_ingles($date){
    $date_pt=date("Y/m/d ",strtotime($date));
    return $date_pt;
}
$agora=date('Y-m-d');
$hora = date('Y-m-d H:i:s'); 
function segurancastring($s) {
$s = addslashes($s);
$s = htmlspecialchars($s);
$s = mysql_escape_string($s);
$s = str_ireplace("SELECT","",$s);
$s = str_ireplace("FROM","",$s);
$s = str_ireplace("WHERE","",$s);
$s = str_ireplace("INSERT","",$s);
$s = str_ireplace("UPDATE","",$s);
$s = str_ireplace("DELETE","",$s);
$s = str_ireplace("DROP","",$s);
$s = str_ireplace("*","",$s);
$s = str_ireplace("&","",$s);
$s = str_ireplace("=","",$s);
$s = str_ireplace("DATABASE","",$s);
$s = str_ireplace("USE","",$s);
return $s;}
if(isset($_SESSION['id'])){
   $id=$_SESSION['id'];
   $nome=$_SESSION['user'];
   $sesion=$_SESSION['sesion'];
    
    
}
$connection = new mysqli("localhost", "root", "", "crud");


