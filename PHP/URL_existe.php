<?php
$url = 'http://abc.dyndns.org:8088/ServicosESL.asmx?wsdl';
$array = get_headers($url);
$string = $array[0];
if(strpos($string,"200"))
  {
    echo 'url existe';
  }
  else
  {
    echo 'url não existe';
  }
?>