<? 
// Desabilita erros da libxml e permite que o usuário obtenha informação do erro como necessitar 
libxml_use_internal_errors(TRUE);

$html = new DOMDocument();
$html->loadHTMLFile('http://carros-saopaulo-zc.temusados.com.br/revenda/10-brasil-multimarcas/sao-paulo/20423');

$spans = array();
foreach($html->getElementsByTagName('section') as $span)
{ 
    $spans[] = $span;
}

print $spans[0]->nodeValue;
echo $spans[2]->nodeValue;
echo $spans[3]->nodeValue;

echo $spans[4]->nodeValue;

echo $spans[5]->nodeValue;
echo $spans[7]->nodeValue;
echo $spans[6]->nodeValue;
echo $spans[8]->nodeValue;
echo $spans[9]->nodeValue;
echo $spans[10]->nodeValue;
echo $spans[11]->nodeValue;
echo $spans[12]->nodeValue;
echo $spans[13]->nodeValue;
echo $spans[14]->nodeValue;
echo $spans[15]->nodeValue;
echo $spans[16]->nodeValue;
 $spans[11]->nodeValue;





?>