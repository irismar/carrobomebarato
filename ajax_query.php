<?php

 require_once('Connections/repasses.php'); 
if( isset( $_REQUEST['query'] ) && $_REQUEST['query'] != "" )
{
    $q = trim(strtoupper( $_REQUEST['query']) );

    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "estado")
    {
	$sql = "SELECT  DISTINCT   marca ,codigo_marca FROM fp_ano where locate('$q',marca) > 0 order by locate('$q',marca) limit 10";
	$r = $mysql->query($sql);
	if ( $r )
	{
	    echo '<ul>'."\n";
	    while( $l =$r->fetch_assoc())
	    {
		$p = trim($l['marca']);
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo '<li id="autocomplete_'.$l['codigo_marca'].'" rel="'.$l['codigo_marca'].'_' . $l['codigo_marca'] . '">'.  $p.'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }
    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "cidade")
    {
	 $sql = isset( $_REQUEST['extraParam'] ) ? " and codigo_marca =".trim( $_REQUEST['extraParam'] ) . " " : "";
	 $sql = "SELECT  DISTINCT modelo,valor,combustivel,ano,id_ano,ano ,codigo_modelo FROM fp_ano where locate('$q',modelo) > 0 $sql order by locate('$q',valor) limit 200";
	$r = $mysql->query($sql);
	if ( count( $r ) > 0 )
	{   echo '<ul>'."\n";
	    while( $l = $r->fetch_assoc())
	    {
                
              
               
		$p =utf8_decode( $l['modelo'])."   ".$l['ano']."  ".$l['combustivel']."  ".number_format($l['valor'],2,',','.')." " ."Codigo Fipe" ." " .$l['id_ano'];
		
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['codigo_modelo'].'"<a  href="'.$l['codigo_modelo'].'_' . $l['codigo_modelo'] . '">'. utf8_encode( $p ) .'</a>'.'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }

}


?>