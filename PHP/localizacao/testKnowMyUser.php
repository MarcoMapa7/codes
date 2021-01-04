<?php
require_once('KnowMyUser.class.php');
////DATABASE DETAILS 
////SET HOSTNAME
//$hostname = "localhost";	
//
////MYSQL USERNAME
//$username ="root";	
//
////MYSQL PASSWORD
//$password="";
//
////MYSQL DATABASE NAME
//$database="cms";
////DATABASE CONNECTION
//try
//{
//$bdd=new PDO('mysql:host='.$hostname.';dbname='.$database,$username,$password,array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION));
//
//}
//catch(Exception $e)
//{
//	die('Erreur:'.$e->getMessage());
//}
// DATABASE CONNECTION CODE END


/*
 First Way : you can specify all your setting yourself by creating an instance
 yourself that will then have all the methods from VSIPD and MapBuilder
*/


$x=new KnowMyUser('66.84.41.158');//specify a specific IP address to work
echo $x->buffered_staticmap("9",'640x200',$bdd);//a way to load a buffered image as suggested by someone
// $x->GetjustBasics_Map($bdd);//this is a short cut method to load a dynamic map but you can set every thing this way:


/*
$x=new KnowMyUser(); //get user IP to work
$map=$this->seehim_onMap();//see this method statement to know the parameters needed here we use the defaults

//from here you can set yourself your map details as specified in the reference.txt file or in the numerous examples 
//of the MapBuilder class package directory.An example could be from there :


// Set the default map type.
$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_ROADMAP);

// Set width and height of the map.
$map->setSize(650, 450);

// Set default zoom level.
$map->setZoom(17);

// Set minimum and maximum zoom levels.
$map->setMinZoom(10);
$map->setMaxZoom(19);

// Disable mouse scroll wheel.
$map->setScrollwheel(false);

// Make the map draggable.
$map->setDraggable(true);

// Enable zooming by double click.
$map->setDisableDoubleClickZoom(false);

// Disable all on-map controls.
$map->setDisableDefaultUI(true);

// Display the map.
$map->show();

*/



/*
second way: use a short cut with predefined map settings 
*/

KnowMyUser::Fastway('66.84.41.158',$bdd);// to know a specific ip location
// KnowMyUser::Fastway(null,$bdd);//to know the client IP address or even without database storage:
// KnowMyUser::Fastway();//to know the client IP address  even without database storage
?>