<?php include_once("crud360/inc/header.php");?>
<?php include_once("crud360/includes/class.crud360.php"); ?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container">
<h4>Easy Setup!</h4>
<h5>Config Setup</h5>
<?php 
	Crud360::renderSource("install/sample.class.config.php");
?>

<h5>Code Setup</h5>
<?php 
	Crud360::renderSource("install/easy.php");
?>
<?php include_once("crud360/inc/examples.php");?>
</div>
<?php include_once("crud360/inc/footer.php"); ?>