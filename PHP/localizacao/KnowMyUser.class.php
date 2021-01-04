<?php
require_once('class.ipdetails.php');
require_once('class.getIp.php');
require_once('class.MapBuilder.php');
/*
I you wish to use google dynamic map API you must be sure to setup  your  API key as asked in Google API Console:
for example use the default API key in this class on a localhost will lead sometimes to:
RefererNotAllowedMapError	Error	
The current URL loading the Google Maps JavaScript API has not been added to the list of allowed referrers.
Please check the referrer settings of your API key on the Google API Console.
See API keys in the Google API Console at https://console.developers.google.com/project/_/apiui/credential. 
For more information, see Best practices for securely using API keys at:https://support.google.com/googleapi/answer/6310037.
*/

class KnowMyUser{
	protected $IP,$DETAILS;
		public function __construct($ip=null) {
			if($ip===null) $this->IP=IP::get();
			else $this->IP=(IP::validate($ip))?$ip:false;
			// var_dump($this->IP);
			if(!$this->IP) return 'Check your IP address and try again';
		}
		
		
		public function vsipdetails_obj($db=false){
			$details=new vsipdetails($this->IP,$db);
			return $details;
		}
		
		public function buffered_staticmap($zoom="9",$size='640x200',$db=false){
			$array=$this->vsipdetails_obj($db);
			$array=$array->scan();
			$url='https://maps.googleapis.com/maps/api/staticmap?center='.$array["loc"].'&zoom='.$zoom.'&size='.$size.'&sensor=false';
			$buf = file_get_contents($url); 
			$map='<img class="map" src="data:image/png;base64,'.base64_encode($buf).'" alt="'.$array["city"].', '.$array["region"].', '.$array["country"].' Map" title="'.$array["city"].', '.$array["region"].', '.$array["country"].' Map">';
			return $map;
		}
		
		public function & seehim_onMap($apikey='AIzaSyB230QxSetZoJiM9noon7FiAQXbc-HPSLU',$db=false){
			$mapbasics=$this->vsipdetails_obj($db);
			$mapbasics=$mapbasics->scan();
			// var_dump($mapbasics);
			$mapbuilder=new MapBuilder();
			$mapbuilder->setApiKey($apikey);
			$loc=explode(',',$mapbasics['loc']);
			$mapbuilder->setCenter($loc[0], $loc[1]);
			// Add a marker with specified color and symbol. 
			$mapbuilder->addMarker($loc[0], $loc[1], array(
				'title' => 'Your Position', 
				'defColor' => '#FA6D6D', 
				'defSymbol' => 'E'
			));
			return $mapbuilder;
		}
		
		public function GetjustBasics_Map($db=false,$apikey='AIzaSyB230QxSetZoJiM9noon7FiAQXbc-HPSLU'){
			$map=$this->seehim_onMap($apikey,$db);
			// var_dump($map);
			// Set the default map type.
			$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_HYBRID);

			// Set width and height of the map.
			$map->setSize(860, 550);

			// Set default zoom level.
			$map->setZoom(14);

			// Make zoom control compact.
			$map->setZoomControlStyle(MapBuilder::ZOOM_CONTROL_STYLE_SMALL);

			// Display the map.
			$map->show();
		}
		
		public static function Fastway($ip=null,$db=false){
			$Fw=new static($ip);
			$Fw->GetjustBasics_Map($db);		
		}
}
?>