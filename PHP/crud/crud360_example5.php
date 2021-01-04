<?php 
// EASY SETUP
// Set your database name, database user, database password and database name in crud360/includes/class.config.php
include_once("crud360/includes/class.crud360.php"); 
$obj_table = new Crud360("users");
//Call process method to process all get/post request (live/ajax),
//!!!!!!!!You must call it before any html is rendered!!!!!!!!!!!
//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
Crud360::process([$obj_table]);
//Begin including html (css, js, head section)
include_once("crud360/inc/header.php");
?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container-fluid">
<h3 align="center"> <strong>Example 5:</strong> Minimal Setup (easy) withthout any layout!</h3>
<?php 
//Use defaultDivs method to place informatory message divs, wherever you will place this call, it will load messages there.
Crud360::defaultDivs(); 
$obj_table->magic();	
?>
<p align="center"><strong><a class="btn btn-primary" href="index.php">Go Back!</a></strong></p>
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php Crud360::javascript([$obj_table]); ?>