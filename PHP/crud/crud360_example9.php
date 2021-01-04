<?php 
// EXAMPLE 1
include_once("crud360/includes/class.crud360.php"); 
//Create objects here
if(isset($_GET['user_id']) && $_GET['user_id']!=0)
{
	$user_id=$_GET['user_id'];

	$users = new Crud360("users");
	$users->columns(["name","email"]);
	$users->where(" WHERE id=:id",["id"=>$user_id]);
	$users->tableHeader(false);
	$users->paginationLinks(false);
	
	$user_links = new Crud360("user_links");
	$user_links->columns(["link","user_id"]);
	$user_links->where(" WHERE user_id=:id",["id"=>$user_id]);
	$user_links->setLookupFields("user_id","users","id","name");
	$user_links->setDefault("user_id",$user_id);
	$user_links->setInputType("user_id","text",$user_id);
	
	$user_quotes = new Crud360("user_quotes");
	$user_quotes->columns(["quote","user_id"]);
	$user_quotes->where(" WHERE user_id=:id",["id"=>$user_id]);
	$user_quotes->setLookupFields("user_id","users","id","name");
	$user_quotes->setDefault("user_id",$user_id);
	$user_quotes->setInputType("user_id","text",$user_id);
	Crud360::process([$users,$user_links,$user_quotes]);
	
	include_once("crud360/inc/header.php");
	?>
	<?php //include_once("crud360/inc/nav.php");?>
	<div class="container-fluid">
	<?php Crud360::defaultDivs(); ?>
	<h2 align="center"> <strong>Example 9:</strong> Single Parent Record with dependent fields </h2>
	<p align="center"><a class="btn btn-primary" href="?user_id=0">Go Back!</a></p>
	<h2 style="border-bottom:1px solid #eee"> Connected information for User:</h2>
	<?php 	
		$users->magic(); 
		//Crud360::renderSource(__FILE__) ; // display source of this current file 
	?>
    <div class="row">
    	<div class="col-md-6">
        	<?php 		
				$user_links->magic(); 
			?>
        </div>
        <div class="col-md-6">
        <?php 
			$user_quotes->magic(); 
		?>
        </div>
    </div>
	</div>
	<?php include_once("crud360/inc/footer.php"); ?>
	<?php Crud360::javascript([$users,$user_links,$user_quotes]); ?>
<?php
}
else
{
	$users = new Crud360("users");
	$users->columns(["name","email"]);
	$users->formatField("name","link","?user_id=CRUD360_CURRENT_ROW_ID");
	Crud360::process([$users]);
	include_once("crud360/inc/header.php");
	?>
	<?php //include_once("crud360/inc/nav.php");?>
	<div class="container-fluid">
	<?php Crud360::defaultDivs(); ?>
	<h2 align="center"> <strong>Example 9:</strong> Single Parent Record with dependent fields </h2>
	<?php 	
		$users->magic(); 
		//Crud360::renderSource(__FILE__) ; // display source of this current file 
	?>
	</div>
	<?php include_once("crud360/inc/footer.php"); ?>
	<?php Crud360::javascript([$users]); 
}
