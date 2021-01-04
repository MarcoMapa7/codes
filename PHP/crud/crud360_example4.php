<?php 
// EXAMPLE 4
include_once("crud360/includes/class.crud360.php"); 
//Check if we are in page
if(Crud360::pageMode())
{
	$table_name=Crud360::$crud360[$_GET[Crud360::$crud360Get]];
	$table = new Crud360($table_name);
	
	switch($table_name)
	{
		case "users" :
		{
			$table->columns(["name","email","department_id","status_id"]);
			$table->setLookupFields("status_id","statuses","id","title");
			$table->setLookupFields("department_id","departments","id","title");
			$table->title("department_id","Department");
			$table->title("status_id","Status");			
			break;
		}
		case "statuses" :
		{
			$table->columns(["title"]);
			$table->heading("Status");

			$table->title("title","Status");
			break;
		}
		case "departments" :
		{
			$table->columns(["title"]);
			$table->title("title","Department");
			break;
		}

		default :
		{
			
		}
		
	}

	//!!!!MAKE SURE TO CALL THIS AFTER YOU HAVE SET ALL THE OPTIONS JUST BEFORE YOUR HTML BEGINS
	//This call processes all form requests for all the objects
	Crud360::process([$table]);
}
//Include bootstrap, datepicker, and essential crud360
include_once("crud360/inc/header.php");
?>
<?php include_once("crud360/inc/nav.php");?>
<div class="container">
<h3 align="center"><strong>Example 4:</strong> All database tables using a single loop on a single page with navigation!</h3>
<?php Crud360::defaultDivs(); ?>
   	<div class="row">
		<div class="col-md-3">
			<div style="padding:15px;background:#f3f3f3;">
			<?php
			
				Crud360::showAllLinks();
			?>
            <hr>
			<?php
				Crud360::showSingleLink("users","Single Link for Users");
			?>		
           <hr>
           </div>

		</div>
		<div class="col-md-9">
           <?php	
		// this method must be called within a renderable region of an html page, it displays records, creates neccessary forms etc...
		if(Crud360::pageMode()) 
		{
			$table->magic();	
		}
		else
		{
			?>
            <p align="center">Click on one of the links to begin!</p>
			<?php	
		}
		?>
		</div>
	</div>
<?php  Crud360::renderSource(__FILE__) ; // display source of this current file ?>
</div>
<?php include_once("crud360/inc/footer.php"); ?>
<?php 
if(Crud360::pageMode()) 
{
	Crud360::javascript([$table]); 
}
?>