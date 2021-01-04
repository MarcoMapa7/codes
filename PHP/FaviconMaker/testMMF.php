<?php
 require_once('MakeMyFavicon.class.php');
 ?>
<!doctype html>
<html>
<head>
<?php
$x=new loadMyfav('moki.gif',false,48,true);
echo $x->getHtml();
?>
</head>
<body>
<?php
 echo'<pre>';
echo $x->getHtml(true);
 echo'</pre>';
echo'<br>';

$x=new loadMyfav('moki.gif',true,48,true);
echo $x->getHtml(true);


?>
</body>
</html>