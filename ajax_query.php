<?php

 require_once('Connections/repasses.php'); 
if( isset( $_REQUEST['query'] ) && $_REQUEST['query'] != "" )
{
    $q = trim(ucwords( $_REQUEST['query']) );

    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "estado")
    {
	$sql = "SELECT * FROM marcas where locate('$q',nome) > 0 order by locate('$q',nome) limit 10";
	$r = $mysql->query($sql);
	if ( $r )
	{
	    echo '<ul>'."\n";
	    while( $l =$r->fetch_assoc())
	    {
		$p = $l['nome'];
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['codigo'].'" rel="'.$l['codigo'].'_' . $l['codigo'] . '">'.  $p.'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }
    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "cidade")
    {
	 $sql = isset( $_REQUEST['extraParam'] ) ? " and codigo_marca =".trim( $_REQUEST['extraParam'] ) . " " : "";
	 $sql = "SELECT * FROM veiculos where locate('$q',modelo) > 0 $sql order by locate('$q',valor) limit 200";
	$r = $mysql->query($sql);
	if ( count( $r ) > 0 )
	{   echo '<ul>'."\n";
	    while( $l = $r->fetch_assoc())
	    {
                
              
               
		$p = $l['marca']."  ".$l['modelo']."   ".$l['ano']."  ".$l['combustivel']."  ".$l['valor']." " ."Codigo Fipe" ." " .$l['id'];
		
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['codigo_modelo'].'"<a  href="'.$l['codigo_modelo'].'_' . $l['codigo_modelo'] . '">'. utf8_encode( $p ) .'</a>'.'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }

}


?><a href=""