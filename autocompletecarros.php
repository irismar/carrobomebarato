<?  $mysql= new mysqli('localhost','root','', 'tabela_fipe');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
if( isset( $_REQUEST['query'] ) && $_REQUEST['query'] != "" )
{
    $q = trim( $_REQUEST['query'] );

    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "estado")
    {
	$sql = "SELECT nome,codigo FROM marcas where locate('$q',nome) > 0 order by locate('$q',nome) limit 10";
	$r = $mysql->query($sql);
	if ( $r )
	{
	    echo '<ul>'."\n";
	    while( $l =$r->fetch_assoc())
	    {
		$p = $l['nome'];
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['codigo'].'" rel="'.$l['codigo'].'">'.  $p.'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }

    if( isset( $_REQUEST['identifier'] ) && $_REQUEST['identifier'] == "cidade")
    {
	 $sql = isset( $_REQUEST['extraParam'] ) ? " and Id_marca = " . trim( $_REQUEST['extraParam'] ) . " " : "";
	$sql = "SELECT * FROM modelo where locate('$q',modelo) > 0 $sql order by locate('$q',modelo) limit 20";
	$r = $mysql->query($sql);
	if ( count( $r ) > 0 )
	{
	    echo '<ul>'."\n";
	    while( $l = $r->fetch_assoc())
	    {
		$p = $l['modelo'];
		$p = preg_replace('/(' . $q . ')/i', '<span style="font-weight:bold;">$1</span>', $p);
		echo "\t".'<li id="autocomplete_'.$l['id'].'" rel="'.$l['id'].'_' . $l['modelo'] . '">'. utf8_encode( $p ) .'</li>'."\n";
	    }
	    echo '</ul>';
	}
    }
}

?>