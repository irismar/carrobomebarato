<?php

/** Classe CRUD - Create, Recovery, Update and Delete
  * @author - Rodolfo Leonardo Medeiros
  * @date - 25/09/2009
  * Arquivo - codigo.class.php
  * @package crud
  */
  
  class crud
  {
    private $sql_ins="";
    private $tabela="";
    private $sql_sel="";
    private $registo="";
    // Caso pretendamos que esta classe seja herdada por outras, então alguns atrubutos podem ser protected

    /** Método construtor
      * @method __construct
      * @param string $tabela
      * @return $this->tabela
      */             
      public function __construct($tabela) // construtor, nome da tabela como parametro
      {
        $this->tabela = $tabela;
        return $this->tabela;
    }
         
    /** Método inserir
      * @method inserir
      * @param string $campos
      * @param string $valores
      * @example: $campos = "codigo, nome, email" e $valores = "1, 'João Brito', 'joao@joao.net'"
      * @return void
      */         
    public function inserir($campos, $valores) // funçao de inserçao, campos e seus respectivos valores como parametros
    {
        $this->sql_ins = "INSERT INTO " . $this->tabela . " ($campos) VALUES ($valores)";
        if(!$this->ins = mysql_query($this->sql_ins))
        {
            die ("<center>Erro na inclusão " . '<br>Linha: ' . __LINE__ . "<br>" . mysql_error() . "<br>
                <a href='index.php'>Voltar ao Menu</a></center>");
        }else{
            $registo="09";
        }
    }
    
    public function log($campos, $valores) // funçao de inserçao, campos e seus respectivos valores como parametros
    {
        $this->sql_ins = "INSERT INTO " . $this->tabela . " ($campos) VALUES ($valores)";
        if(!$this->ins = mysql_query($this->sql_ins))
        {
            die ("<center>Erro na inclusão " . '<br>Linha: ' . __LINE__ . "<br>" . mysql_error() . "<br>
                <a href='index.php'>Voltar ao Menu</a></center>");
        }else{
            $registo="09";
        }
    }

    public function atualizar($camposvalores, $where = NULL) // funçao de ediçao, campos com seus respectivos valores e o campo id que define a linha a ser editada como parametros
    {
        if ($where)
        {
            $this->sql_upd = "UPDATE  " . $this->tabela . " SET $camposvalores WHERE $where";           
        }else{
            $this->sql_upd = "UPDATE  " . $this->tabela . " SET $camposvalores";
          }
         
        if(!$this->upd = mysql_query($this->sql_upd))
        {
            die ("<center>Erro na atualização " . "<br>Linha: " . __LINE__ . "<br>" .mysql_error() . "<br>
                <a href='index.php'>Voltar ao Menu</a></center>");
        }else{
             "<center>Registro Atualizado com Sucesso!<br><a href='index.php'>Voltar ao Menu</a></center>";
        }
    }     

    /** Método excluir
      * @method excluir
      * @param string $where
      * @example: $where = " codigo=2 AND nome='João' "
      * @return void
      */         
    public function excluir($where = NULL) // funçao de exclusao, campo que define a linha a ser editada como parametro
    {
        if ($where)
        {
            $this->sql_sel = "SELECT * FROM " . $this->tabela . " WHERE $where";
            $this->sql_del = "DELETE FROM " . $this->tabela . " WHERE $where";
        }else{
            $this->sql_sel = "SELECT * FROM " . $this->tabela;
            $this->sql_del = "DELETE FROM " . $this->tabela;
          }
          $sel=mysql_query($this->sql_sel);
        $regs=mysql_num_rows($sel);
       
      if ($regs > 0){
        if(!$this->del = mysql_query($this->sql_del))
        {
            die ("<center>Erro na exclusão " . '<br>Linha: ' . __LINE__ . "<br>" .mysql_error() ."<br>
                <a href='index.php'>Voltar ao Menu</a></center>" );
        }else{
             "<center>Registro Excluído com Sucesso!<br><a href='index.php'>Voltar ao Menu</a></center>";
        }
      }else{
             "<center>Registro Não encontrado!<br><a href='index.php'>Voltar ao Menu</a></center>";
      }
    }     
       
 }         
$data=date('Y/m/d');
$timestamp = strtotime("+7 days");
// Exibe o resultado
$data_devolver=date('Y/m/d ', $timestamp); // 27/03/2009 05:02   

function limitarTexto($texto, $limite, $quebrar = true){
  //corta as tags do texto para evitar corte errado
  $contador = strlen(strip_tags($texto));
  if($contador <= $limite):
    //se o número do texto form menor ou igual o limite então retorna ele mesmo
    $newtext = $texto;
  else:
    if($quebrar == true): //se for maior e $quebrar for true
      //corta o texto no limite indicado e retira o ultimo espaço branco
      $newtext = trim(mb_substr($texto, 0, $limite))."...";
    else:
      //localiza ultimo espaço antes de $limite
      $ultimo_espaço = strrpos(mb_substr($texto, 0, $limite)," ");
      //corta o $texto até a posição lozalizada
      $newtext = trim(mb_substr($texto, 0, $ultimo_espaço))."...";
    endif;
  endif;
  return $newtext;
}
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


?>
