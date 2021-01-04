<?php 
// EASY SETUP
// Set your database name, database user, database password and database name in crud360/includes/class.config.php
include_once("crud360/includes/class.crud360.php"); 
$obj_table = new Crud360("table");
//Call process method to process all get/post request (live/ajax),
//!!!!!!!!You must call it before any html is rendered!!!!!!!!!!!
Crud360::process([$obj_table]);
//Begin including html (css, js, head section)
include_once("crud360/inc/header.php");
?>
<div class="container">
<?php 
//Use defaultDivs method to place informatory message divs, wherever you will place this call, it will load messages there.
Crud360::defaultDivs(); 
$obj_table->magic();	
?> 
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php Crud360::javascript([$obj_table]); ?>