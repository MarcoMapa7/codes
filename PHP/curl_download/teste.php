<?php
ini_set('error_reporting', E_ALL);
    ini_set("display_errors", 1);
	
	set_time_limit(0);
 
$fp = fopen ('teste.exe', 'w+');
 
$url = "http://downloadirpf.receita.fazenda.gov.br/irpf/2018/irpf/arquivos/IRPF2018Win32v1.3.exe";
 
$ch = curl_init(str_replace(" ","%20",$url));
 
curl_setopt($ch, CURLOPT_TIMEOUT, 50);

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
 
$data = curl_exec($ch);

curl_close($ch);
?>