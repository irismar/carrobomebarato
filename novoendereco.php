<?php
 if (IsLoggedIn()) {
if(isset($_GET["novo"])){ 
 include("/map/index.php");
  include("rodape.php"); 
  exit(); }
 if(isset($_GET["facebook"])){
 include("mapa_cadastro.html");
  include("rodape.php"); exit();
   }
 
 
 if(isset($_GET["cad"])) {
 $_SESSION['endereco']=$_GET["cad"];
 include("lx.php");  }

 }