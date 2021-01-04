<?php
  
  include("../../../init.php");
  require("includes/include.php");
  $urls     = $GLOBALS['ShopPath'];
  $nomeloja = $GLOBALS['StoreName'];
  echo "<html>\r\n<head>\r\n<title>Retorno de Dados - Cielo</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\" />\r\n";
  echo "<s";
  echo "tyle>\r\nbody, td, th, input, option, select, button {\r\n\tfont-size: 16px;\r\n\tfont-family: \"segoe ui\", arial,tahoma,sans-serif;\r\n\ttext-shadow: 2px 2px 5px #CCCCCC;\r\n}\r\n</style>\r\n</head>\r\n<body>\r\n<center>\r\n<fieldset>\r\n";
  global $itemId;
  $id              = $_GET['id'];
  $itemId          = base64_decode($id);
  $sql             = $GLOBALS['ISC_CLASS_DB']->Query("SELECT * FROM cielo WHERE pedido=\"" . $itemId . "\"");
  $dados           = $GLOBALS['ISC_CLASS_DB']->Fetch($sql);
  $afiliacao       = GetModuleVariable("checkout_cielo", "afiliacao");
  $chave           = GetModuleVariable("checkout_cielo", "chave");
  $modo            = GetModuleVariable("checkout_cielo", "modo");
  $juros           = GetModuleVariable("checkout_cielo", "juros");
  $desconto        = GetModuleVariable("checkout_cielo", "desconto");
  $selectorder     = $GLOBALS['ISC_CLASS_DB']->Query("select * from [|PREFIX|]orders where orderid='" . $itemId . "'");
  $fetch_order     = $GLOBALS['ISC_CLASS_DB']->Fetch($selectorder);
  $clientecustomer = $fetch_order['ordcustid'];
  $selectcustomer  = $GLOBALS['ISC_CLASS_DB']->Query("select * from [|PREFIX|]customers where customerid='" . $clientecustomer . "'");
  $resultado3      = $GLOBALS['ISC_CLASS_DB']->Fetch($selectcustomer);
  if ($modo == "T") {
      $urlvisa = TESTE;
  } else {
      $urlvisa = PRODUCAO;
  }
  define("ENDERECO", $urlvisa);
  $Pedido                    = new Pedido();
  $Pedido->dadosEcNumero     = $afiliacao;
  $Pedido->dadosEcChave      = $chave;
  $Pedido->dadosPedidoNumero = $itemId;
  $Pedido->tid               = $dados['tid'];
  $objResposta               = $Pedido->RequisicaoConsulta();
  $status                    = $objResposta->status;
  if ($status == "4" || $status == "6") {
      $finalizacao = true;
  } else {
      $finalizacao = false;
  }
  if ($finalizacao == true) {
      $objResposta = $Pedido->RequisicaoCaptura();
  }
  $Pedido->status = $objResposta->status;
  $status         = $Pedido->getStatus();
  $aa             = simpleXMLToArray($objResposta);
  if (isset($aa['codigo']) && $aa['codigo'] == "030") {
      echo "<p>O pedido solicitado ja foi capturado e aprovado!</p>";
  } else if ($Pedido->status == 6 || $Pedido->status == 4) {
      echo "<h2>" . $status . "</h2>";
      echo "<hr>";
      echo "<b>Cart&atilde;o</b>: " . @strtoupper($aa['forma-pagamento']['bandeira']) . "<br>";
      echo "<b>Parcela(s)</b>: " . $aa['forma-pagamento']['parcelas'] . "x de " . number_format($aa['dados-pedido']['valor'] / 100 / $aa['forma-pagamento']['parcelas'], 2, ".", ",") . " R\$<br>";
      echo "<b>TID</b>: " . $aa['tid'] . "<br>";
      echo "<b>Pedido</b>: " . $itemId . "<br>";
      echo "<b>Valor</b>: " . number_format($aa['dados-pedido']['valor'] / 100, 2, ".", ",") . " R\$<br>";
      echo "<b>Data</b>: " . date("d/m/Y") . "<br>";
      echo "<b>LR</b>: " . $aa['autorizacao']['lr'] . "<br>";
      echo "<br><b>" . $resultado3['firstname'] . " " . $resultado3['lastname'] . "</b><br>_____________________________________<br><br>";
      echo "<b>" . $nomeloja . "</b><br>" . $urls;
      @UpdateOrderStatus($itemId, $aprovadocielo);
      $msg   = "" . $status . " | Cartao: " . @strtoupper($aa['forma-pagamento']['bandeira']) . " | Parcela(s): " . $aa['forma-pagamento']['parcelas'] . " | LR: " . $aa['autorizacao']['lr'] . "";
      $query = "UPDATE [|PREFIX|]orders SET ordpayproviderid = '" . $aa['tid'] . "', ordpaymentstatus = '" . $msg . "' where orderid = '" . $itemId . "'";
      $GLOBALS['ISC_CLASS_DB']->Query($query);
  } else {
      echo "<h2>" . $status . "</h2>";
      echo "<hr>";
      echo "<b>Cart&atilde;o</b>: " . @strtoupper($aa['forma-pagamento']['bandeira']) . "<br>";
      echo "<b>Parcela(s)</b>: " . $aa['forma-pagamento']['parcelas'] . "x de " . number_format($aa['dados-pedido']['valor'] / 100 / $aa['forma-pagamento']['parcelas'], 2, ".", ",") . " R\$<br>";
      echo "<b>TID</b>: " . $aa['tid'] . "<br>";
      echo "<b>Pedido</b>: " . $itemId . "<br>";
      echo "<b>Valor</b>: " . number_format($aa['dados-pedido']['valor'] / 100, 2, ".", ",") . " R\$<br>";
      echo "<b>Data</b>: " . date("d/m/Y") . "<br>";
      echo "<br>";
      echo "<b>" . $nomeloja . "</b><br>" . $urls;
      @UpdateOrderStatus($itemId, $canceladocielo);
      $msg   = "" . $status . " | Cartao: " . @strtoupper($aa['forma-pagamento']['bandeira']) . " | Parcela(s): " . $aa['forma-pagamento']['parcelas'] . "";
      $query = "UPDATE [|PREFIX|]orders SET ordpayproviderid = '" . $aa['tid'] . "', ordpaymentstatus = '" . $msg . "' where orderid = '" . $itemId . "'";
      $GLOBALS['ISC_CLASS_DB']->Query($query);
  }
  echo "<script type=\"text/javascript\">window.opener.location.href=\"" . $GLOBALS['ShopPath'] . "\";</script>";
  echo "\r\n\r\n\r\n</fieldset>\r\n<br>\r\n<a href='javascript:print();'>IMPRIMIR RECIBO</a>\r\n</center>\r\n</body>\r\n</html>";
?>