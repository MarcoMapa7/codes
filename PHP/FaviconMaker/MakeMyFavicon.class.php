<?php
				/* IMPORTANT: READ BEFORE DOWNLOADING, COPYING, INSTALLING OR USING.
				
				 By downloading, copying, installing or using the software you agree to this license.
				 If you do not agree to this license, do not download, install,
				 copy or use the software.
				
				
										  License Agreement
									  For PHP FAVICON MAKER V 1.0.0
				
				Copyright (C) 2017, Akpe Aurelle Emmanuel Moïse Zinsou, all rights reserved.
				
				Redistribution and use in source and binary forms, with or without modification,
				are permitted provided that the following conditions are met:
				
				  * Redistribution's of source code must retain the above copyright notice,
					this list of conditions and the following disclaimer.
				
				  * Redistribution's in binary form must reproduce the above copyright notice,
					this list of conditions and the following disclaimer in the documentation
					and/or other materials provided with the distribution.
				
				  * The name of the copyright holders may not be used to endorse or promote products
					derived from this software without specific prior written permission.
				
				This software is provided by the copyright holders and contributors "as is" and
				any express or implied warranties, including, but not limited to, the implied
				warranties of merchantability and fitness for a particular purpose are disclaimed.
				In no event shall Akpe Aurelle Emmanuel Moïse Zinsou or contributors be liable for 
				any direct, indirect, incidental, special, exemplary, or consequential damages(including, 
				but not limited to, procurement of substitute goods or services;loss of use,  data, or 
				interruption) however caused and on any theory of profits; or business liability, 
				whether  in contract, strict liability, or tort (including negligence or otherwise)
				arising in any way out of the use of this software, even if advised of the possibility
				of such damage.

				EZAMA contact:leizmo@gmail.com*/

				class MMFavicon{
					protected $source,$extension=null,$dest,$Imageinfo,$path;

					/*
					*@param (string)$path  ;path to the file which must be used to build the favicon  
					*/
					public  function __construct($path){
						if(file_exists($path)){
							
							if(in_array(strtolower(pathinfo ( $path ,PATHINFO_EXTENSION)),array('png','gif','jpg','jpeg'))){
								$this->source=$path;
								$this->extension=strtolower(pathinfo ( $path ,PATHINFO_EXTENSION));
								$this->extension=($this->extension=='jpeg')?'jpg':$this->extension;
								$this->Imageinfo=@getimagesize($this->source);
							}else{
								$this->source=false;
								return false;
							}
						}else{
							$this->source=false;
							return false;
						}
					}
					/*
					*Build a new favicon from the given file and save it.
					*@param (string)$dest destination of the favicon once created
					*@param (int)$size may be 16,32 or 48...But not that 16 is the standart size for a favicon
					*@param (bool)$forcetype may be true to output an favicon.ico file or false to use source file normal extension...*note that not all browsers allow other extensions than .ico
					*@param (bool)$animated may be true to say if you use an aimated gif as chosen based image.
					*/ 

					public function makeIt($dest="",$forcetype=false,$size=16,$animated=false){
						$info = new SplFileInfo($dest);
						
						$dest=$info->getRealPath();
						$dest=str_replace('\\','/',$dest);
						$this->path=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. substr($dest,strlen($_SERVER['DOCUMENT_ROOT']));
						
						$size=($size!=16&&$size!=32&&$size!=48)?16:$size;
						
						if($forcetype){
							//make a favicon.ico file .It means force the .ico extension
							if($this->extension!='bmp'){
								
								require_once('combox.php');
								$ToBMP = new ToBmp();
								$ToBMP->image_info($this->source);
								$ToBMP->new_width  = $size;
								$ToBMP->new_height = $size;
								
								if(is_dir($dest)){
									$ToBMP->imagebmp("$dest/favicon.ico");
									$this->dest="$dest/favicon.ico";
								}else{
									$ToBMP->imagebmp("favicon.ico");
									$this->dest="favicon.ico";
								}
								$this->extension='ico';
							}else{
								if(version_compare(PHP_VERSION, '7.2.0') >= 0){
									$imageData = imagecreatefrombmp($this->source);
									$resizedImage = imagecreatetruecolor($size, $size);
									$imageColora = imagecolorallocate($resizedImage, 0, 0, 0);
									imagecolortransparent($resizedImage, $imageColora);
									imagealphablending($resizedImage, false);
									imagesavealpha($resizedImage, true);
									imagecopyresampled($resizedImage, $imageData, 0, 0, 0, 0, $size,$size, $this->imageInfo[0], $this->imageInfo[1]);
									if(imagebmp($resizedImage,((is_dir($dest))?"$dest/favicon.ico":"favicon.ico"))) {  
										imagedestroy($resizedImage);
										$this->dest=(is_dir($dest))?"$dest/favicon.ico":"favicon.ico";
										return true;
									}else{
										imagedestroy($resizedImage);
										return false;
									}
								}else{
									return 'Your PHP version must be >= 7.2.0 .Your current version is '. PHP_VERSION . '.';
								}
							}
						
						}else{
							//just resize to the needed.Any given extension must be used as given... 
							if($animated&&$this->extension=='gif'){
								require_once('combox.php');
								$nGif = new GIF_eXG($this->source,1);
								if(is_dir($dest)){
									@$nGif->resize("$dest/favicon.gif",$size,$size,0,1);
									$this->dest="$dest/favicon.gif";
								}else{
									@$nGif->resize("favicon.gif",$size,$size,0,1);
									$this->dest="favicon.gif";
								}
							}else{
								if($this->extension!='bmp'){
									require_once('combox.php');
									$img = new image_sizer();
									$img->setImage($this->source);
									$img->setSize($size, $size);
									$this->dest=(is_dir($dest))?"$dest/favicon.$this->extension":"favicon.$this->extension";
									if($img->saveTo($this->dest, 100)){ 
										return true;
									}else{
										return  false;
									}
								}else{
									if(version_compare(PHP_VERSION, '7.2.0') >= 0){
										$imageData = imagecreatefrombmp($this->source);
										$resizedImage = imagecreatetruecolor($size, $size);
										$imageColora = imagecolorallocate($resizedImage, 0, 0, 0);
										imagecolortransparent($resizedImage, $imageColora);
										imagealphablending($resizedImage, false);
										imagesavealpha($resizedImage, true);
										imagecopyresampled($resizedImage, $imageData, 0, 0, 0, 0, $size,$size, $this->imageInfo[0], $this->imageInfo[1]);
										if(imagebmp($resizedImage,((is_dir($dest))?"$dest/favicon.ico":"favicon.ico"))) {  
											imagedestroy($resizedImage);
											$this->dest=(is_dir($dest))?"$path/favicon.ico":"favicon.ico";
											return true;
										}else{
											imagedestroy($resizedImage);
											return false;
										}
									}else{
										//return 'Your PHP version must be >= 7.2.0 .Your current version is '. PHP_VERSION . '.';
										return false;
									}
								}
							}
							
						}
					}

					/*return  the new favicon path.*/

					public function getDest(){
						if($this->dest) return $this->dest;
					}


					/*return  the new favicon full link.*/

					public function getHref(){
						if($this->path) return $this->path."/favicon.$this->extension";
					}
				}


				class loadMyfav{
					protected $source,$code;
					/*
					*use to call the MMFavicon class to build the favicon and generate the html code to load it once created.
					*@param (string)$path  ;path to the file which must be used to build the favicon 
					*@param (int)$size may be 16,32 or 48...But not that 16 is the standart size for a favicon
					*@param (bool)$forcetype may be true to output an favicon.ico file or false to use source file normal extension...*note that not all browsers allow other extensions than .ico
					*@param (bool)$animated may be true to say if you use an aimated gif as chosen based image.
					
					*/
					public  function __construct($path,$forcetype=true,$size=16,$animated=false){
						
						if(file_exists($path)){
						
							if(in_array(strtolower(pathinfo ( $path ,PATHINFO_EXTENSION)),array('png','gif','jpg','jpeg','ico'))){
								$this->source=$path;
								$this->extension=strtolower(pathinfo ( $path ,PATHINFO_EXTENSION));
								$this->Imageinfo=@getimagesize($this->source);
								if((($this->Imageinfo[0]!=16||$this->Imageinfo[1]!=16)&&($this->Imageinfo[0]!=32||$this->Imageinfo[1]!=32)&&($this->Imageinfo[0]!=48||$this->Imageinfo[1]!=48))&&$this->extension!='ico'){
									$createmyfav=new MMFavicon($path);
									$createmyfav->makeit(pathinfo ($path,PATHINFO_DIRNAME),$forcetype,$size,$animated);
									$path=$createmyfav->getDest();
									$imageData=getimagesize($path);
									$href=$createmyfav->getHref();
									// var_dump($imageData);
									if($forcetype){
										$this->code='<link rel="icon" type="'.$imageData['mime'].'" href="'.$href.'">
										<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="'.$href.'"><[![endif]-->';
									}else{
									//no favicon for IE (sorry IE)
										$this->code='<link rel="icon" type="'.$imageData['mime'].'" href="'.$href.'">';
									}
									
								}elseif((($this->Imageinfo[0]!=16||$this->Imageinfo[1]!=16)&&($this->Imageinfo[0]!=32||$this->Imageinfo[1]!=32)&&($this->Imageinfo[0]!=48||$this->Imageinfo[1]!=48))&&$this->extension=='ico'){
									$info = new SplFileInfo($path);
									$href=$info->getRealPath();
									$href=str_replace('\\','/',$href);
									$href=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. substr($href,strlen($_SERVER['DOCUMENT_ROOT']))."/favicon.$this->extension";
									$this->code='<link rel="icon" type="image/x-icon" href="'.$href.'">
									<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="'.$href.'"><[![endif]-->';
								}elseif((($this->Imageinfo[0]==16&&$this->Imageinfo[1]==16)||($this->Imageinfo[0]==32&&$this->Imageinfo[1]==32)||($this->Imageinfo[0]==48&&$this->Imageinfo[1]==48))&&$this->extension=='ico'){
									$info = new SplFileInfo($path);
									$href=$info->getRealPath();
									$href=str_replace('\\','/',$href);
									$href=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. substr($href,strlen($_SERVER['DOCUMENT_ROOT']))."/favicon.$this->extension";
									$this->code='<link rel="icon" type="'.$this->Imageinfo['mime'].'" href="'.$href.'">
									<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="'.$href.'"><[![endif]-->';		
								}elseif((($this->Imageinfo[0]==16&&$this->Imageinfo[1]==16)||($this->Imageinfo[0]==32&&$this->Imageinfo[1]==32)||($this->Imageinfo[0]==48&&$this->Imageinfo[1]==48))&&$this->extension!='ico'&&!$forcetype){
									$info = new SplFileInfo($path);
									$href=$info->getRealPath();
									$href=str_replace('\\','/',$href);
									$href=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. substr($href,strlen($_SERVER['DOCUMENT_ROOT']))."/favicon.$this->extension";
									//no favicon for IE (sorry IE)
									$this->code='<link rel="icon" type="'.$this->Imageinfo['mime'].'" href="'.$href.'">';
								}elseif((($this->Imageinfo[0]==16&&$this->Imageinfo[1]==16)||($this->Imageinfo[0]==32&&$this->Imageinfo[1]==32)||($this->Imageinfo[0]==48&&$this->Imageinfo[1]==48))&&$this->extension!='ico'&&$forcetype){
									$createmyfav=new MMFavicon($path);
									$createmyfav->makeit(pathinfo ($path,PATHINFO_DIRNAME),$forcetype,$size,$animated);
									$path=$createmyfav->getDest();
									$href=$createmyfav->getHref();
									$imageData=getimagesize($path);
									$this->code='<link rel="icon" type="'.$imageData['mime'].'" href="'.$href.'">
										<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="'.$href.'"><[![endif]-->';
								}
							}else{
								$this->source=false;
								return false;
							}
						}else{
							$this->source=false;
							return false;
						}
					}
					
					/*
					*return  the new favicon html code.
					@param $toscreen: use to choose if the code must be used as html to be interpreted or just as a string to show on screen
					*/
					public function getHtml($toscreen=false){
						if($this->code) return (($toscreen)?htmlspecialchars($this->code):$this->code);
					}
				}


?>