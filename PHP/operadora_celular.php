<?php
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1);
//$fone = $_POST['tel_fone']; 
$fone = '14998210808'; 
$fone = preg_replace("/[^0-9]/", "", $fone); function get_operadora($fone){ $url = "http://consultanumero.info/consulta";
$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0"); 
curl_setopt ($ch, CURLOPT_REFERER, 'http://google.com.br/'); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt ($ch, CURLOPT_POST, 1); 
curl_setopt ($ch, CURLOPT_POSTFIELDS, "tel=$fone"); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true); 
$data = curl_exec ($ch); if(preg_match("/(oi)/",$data )){ $resultado = "OI"; } if(preg_match("/(vivo)/",$data )){ $resultado = "VIVO"; } if(preg_match("/(tim)/",$data )){ $resultado = "TIM"; } if(preg_match("/(claro)/",$data )){ $resultado = "CLARO"; } if(preg_match("/(nextel)/",$data )){ $resultado = "NEXTEL"; } return trim($resultado); curl_close ($ch); } 
$operadora = get_operadora($fone);

echo $operadora;
?>