<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://aereo.sislognet.com.br/rastrdetail2.aspx?id=3586&lu=cless&lp=cless&NF=195245");
//curl_setopt($ch, CURLOPT_URL, "http://aereo.sislognet.com.br/rastrdetail2.aspx?id=3586&lu=cless&lp=cless&NF=12");
//curl_setopt($ch, CURLOPT_URL, "http://aereo.sislognet.com.br/rastrdetail2.aspx?id=3586&lu=cless&lp=cless&NF=".(int)$nota['notareferencia']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($post));

$output = curl_exec($ch);

curl_close($ch);
$doc = new DOMDocument();
	$doc->formatOutput = true;
	$doc->loadHTML($output);
	
	$xpath = new DOMXpath($doc);
	$elemento = $xpath->query( "//td[@id='OcorrDesc']" )->item( 0 )->nodeValue;
	
	//echo $elemento;
        $entregue = 'REALIZADO NORMALMENTE';
        
        $pos = strpos( $elemento, $entregue );
              
      if ($pos === false) {
            echo 'NF não Encontrada ou Pedido em Transito';
        }else{
            echo 'Pedido Entregue';
        }
     echo $output;    
?>