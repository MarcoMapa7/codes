<?php
include_once("class.database.php");
//include_once("class.external.database.php"); //Only needed if you want to read data from other databases and incorporate it in this one.
error_reporting(Config::$phpErrorMode);
//###########################DISCLAIMER##################################
//#   																	#
//# 	THIS FREE SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND		#
//# 	ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT			#
//# 	LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND		#
//# 	FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO			#
//# 	EVENT SHALL THE AUTHOR OR ANY CONTRIBUTOR BE LIABLE FOR			#
//# 	ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR		#
//# 	CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,			#
//# 	EFFECTS OF UNAUTHORIZED OR MALICIOUS NETWORK ACCESS;			#
//# 	PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,		#
//# 	DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED		#
//# 	AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT		#
//# 	LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)			#
//# 	ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN		#
//# 	IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.					#
//#  																	#
//#######################################################################

///////////////////////////////////////////////////////////////////////*/
/*------------------------------ NOTICE -------------------------------*\
| 			Product Name	:	Crud360			    					|
|   		Organization	: 	Orbit360 (R)							|
| 			Type			:	Create, Read, Update & Delete CodeGen	|
| 			Author			:	Usman Mughal							|
| 			Created			:	24-11-2016								|
| 			Updated			:	25-11-2016								|
| 			Doctype			:	PHP										|
| 			Version			:	1.0b									|
| 			Copyright		:	Orbit360(R) - http://orbit360.net		|
| 			License			:	Attribution Assurance License			|
|							    https://opensource.org/licenses/AAL		|
|								read LICENSE.md for more info			|
| 			Dependencies	:	bootstrap 4.0, jquery 1.11.2,       	|
|							    tinymce 4.4.3, maskedinput 1.4.1    	|
|								(All bundled dependencies have their	|
|								corresponding license intact to credit	|
|								their authors).							|
|			Platform		:	LAMP/WAMP 								|
|-----------------------------------------------------------------------|
| Serves as a major class to Manipulate database tables querying 		|
| them, inserting data in a convinient way. This class incorporates 	|
| Jquery/Bootstrap and several other plugins to make programmers life	|
| easier by allowing them to generate code like never before with		|
| extereme customization capabilities of crud360, developers can build 	|
| any kind of a back end system with little or no coding at all.  		|
| This software is capable of generation code for a database table to 	|
| display records, edit records, and add records. All you need is to 	|
| write name of the table you're trying to create a crud for, and 		|
| voila! crud360 will take care of your tabular records editing,		|
| updating and deleting records. 										|
| Note: Use unique keys to prevent accidental duplication upon page 	|
| reload espacially when using more than one tables on one page.		|
\*---------------------------------------------------------------------*/
///////////////////////////////////////////////////////////////////////*/
/*-------------------- Crud360 Feature List ---------------------------/*
|																		|
|	              INCLUDING BUT NOT LIMITED TO							|
|																		|
|	* PDO based (SQL injection free)									|
|	* Use where clause (hide certain rows if you know SQL)				|
|	* Hide/Show columns	(change order of display/forms					|
|	* Displays dropdowns against linked values (with 'where' clause 	|
|     filter (named placeholders :name) paired with associative key->val|
|     array to be used ) see examples									|
|	* Override linked value dropdowns with radios (checks experimental)	|
|	* Display custom dropdown values (by supplying an associative 		|
|	  key/value pair array)												|
|	* Compound values (with SQL CONCAT) in linked values				|
|	* Compound values (with SQL CONCAT) in reports values				|
|	* Auto Column Names													|
|	* Auto Table Name Headings											|
|	* Override Column Heading											|
|	* Format column value(s) (as image, video, link, date, htmlColor )	|
|	* Force input types (override defaults)								|
|	* Set Rich text fields (using tinymce								|
|	* Auto date/datetime/timestamp picker								|
|	* Override form templates using simple tpl files					|
|	* Clip column values (all, certain fields)							|
|	* Auto hide excess columns on mobile view							|
|	* Adjust to mobile view												|
|	* Load as many tables as you want on a single page					|
|	* Style as per your needs (your own layout)							|
|	* No javascript to write											|
|	* Enforces a primary key with auto_increment (if your table lacks 	|
|	  a Primary key and an auto_increment field Crud360 will not work)	|
|	* Set inputs autorequired (based on database null/not null values	|
|	* Set inputs required explicitly									|
|	* Set inputs readonly												|
|	* Auto readonly for timestamps										|
|	* Prevention of primarykey editing 									|
|	        AND MUCH MORE!!! AND MUCH MORE TO COME!						|
\*----------------------------------------------------------------------*/
class Crud360 {
	private $table;
	private $primaryKey;
	private $tableDefinition;
	private $fields;
	private $autoTitle;
	private $autoPlaceholder;
	private $autoRequired;
	private static $autoLength = true;
	private $js;
	private $nof;
	private $method;
	private $submitName;
	private $tableProcessIdentifier;
	private $lastMsg;
	private $signatureField;
	private $nor;
	private $formHeading;
	private $recordHeading;
	private $recordSerial;
	private $editTimestamp;
	private $modalForm;
	private $autoFormStructure;
	private $formSpace;
	private $readOnlyTimestamps;
	private $showLastMsg;
	private $tableTitle;
	private $whereClause;
	private $whereClauseValues;
	private $addFormTpl;
	private $recordTpl;	
	private $recordKeys;	
	private $supressedTotal;	
	private $clipAllLongText;
	private $maskPasswords;	
	private $sqlOrder;	
	private $maxRecords;	
	private $guessTitle;	
	private $allColumns;	
	private $xsField;	
	private $tableHeader;	
	private $search;	
	private $paginationLinks;	
	private $addButton;	
	private $addNew;	


	private static $generatePkAutoIncKey = true; // ITS A DML COMMAND
	private static $fieldOriginalTips = true;
	private static $noDeleteButton = false;
	private static $opWidth = "";
	//Class variables
	public static $crud360Get = "crud360_section";
	public static $crud360PkGenGet = "crud360_gen_pk_inc";
	public static $crud360Keys;
	public static $crud360;
	private static $showSource = false;
	private static $supressPrimaryKeyAutoInc = false;
	private static $htmlNamedColors = array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');

	//################## Class Constructor ###########################
	// your table must have a primary key with auto_increment active or
	// or this class will attempt to create one (if you have sufficient
	// privlages, if it fails, you will be provided with a DML sql 
	// statement you can run in your phpmyadmin/mysql console.
	public function __construct($table,$method='post',$signatureField='')
	{
		
		if(!self::isBaseTable($table))
		{
			return false;
		}
		global $DB;
		$this->signatureField = $signatureField;
		$this->lastMsg = "";
		$this->method= $method;
		$this->js = "";
		$this->table = $table;
		$this->submitName = $this->table."_submit";
		$this->tableProcessIdentifier = md5(config::$dbName.$this->table);
		$this->autoRequired = true;
		$this->formHeading = true;
		$this->recordHeading = false;
		$this->recordSerial = false;
		$this->editTimestamp = false;
		$this->modalForm = false;
		$this->autoFormStructure = true;
		$this->formSpace = 12;	//defaults to bootstrap 12 colum
		$this->readOnlyTimestamps = true;	//sets all timestamps to readonly
		$this->columns = array();	//defaults to all (shows all columns if none if specified
		$this->showLastMsg = false;	//defaults to bootstrap 12 colum
		$this->tableTitle = ucwords(str_replace("_"," ",$this->table));	//defaults to bootstrap 12 colum
		$this->whereClause = "WHERE 1 ";
		$this->whereClauseValues = array();
		$this->addFormTpl='';
		$this->recordTpl='';		
		$this->recordKeys=false;		
		$this->clipAllLongText = false;
		$this->supressedTotal = 0;
		$this->maskPasswords = true;
		$this->sqlOrder = "desc";
		$this->maxRecords = 10;	//default records per (records page)
		$this->guessTitle = true;	
		$this->tableHeader = true;	
		$this->search = true;	
		$this->addNew = true;	
		$this->paginationLinks = true;	
		$this->addButton = "";	
		$sql ="describe $table";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$this->fields = $stmt->fetchAll();
		$this->nof = count($this->fields);
		$this->primaryKey = "";
		$pk_available = "";
		$pk_type = "";
		
		//try to detect a primary key with auto increment 
		for($i=0;$i<$this->nof;$i++)
		{

			if($this->fields[$i]['Key']=='PRI' && $this->primaryKey=="")
			{
				if($this->fields[$i]['Extra']=='auto_increment')
				{
					if($this->primaryKey=="")
					{
						$this->primaryKey = $this->fields[$i]['Field'];
					}
				}
				else
				{
					$pk_available = $this->fields[$i]['Field'];
					
					$tp = explode("(",$this->fields[$i]['Type']);
					if(is_array($tp) && count($tp)>1)
					{
						$pk_type = $this->fields[$i]['Type'] = $tp[0];
					}


				}
				
			
			}
		}
		
		//if generate key is clicked, and there's no PK with auto_inc, install
		$genGetKey = self::$crud360PkGenGet;
		if($this->primaryKey=='' && self::$generatePkAutoIncKey==true && isset($_GET["$genGetKey"]) && self::isBaseTable($table))
		{
			$pk_key_name = "crud360_".$this->tableProcessIdentifier."_id";
			//var_dump(" We're in luck ");
			
			if($pk_available!='' && $pk_type=='int')
			
				$gendml = "ALTER TABLE `$table` CHANGE `$pk_available` `$pk_available` $pk_type NOT NULL AUTO_INCREMENT;";

			else
				$gendml = "ALTER TABLE `$table` ADD `$pk_key_name` INT NOT NULL AUTO_INCREMENT PRIMARY KEY;";
			
			try {
				$stmt = $DB->PDO->prepare($gendml);
				$stmt->execute();
			}
			catch(PDOException $e)
			{
					self::primitiveMessage("<strong>Fatal Error: </strong> ".$e->getMessage().", auto generation of primary key failed, please use mysql console/phpmyadmin to run the following DML SQL on `".Config::$dbName."` database.");
					echo "<div align='center'><pre>$gendml</pre></div>";
					exit();
				}
			//echo $gendml;
		}


		$sql ="describe $table";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$this->fields = $stmt->fetchAll();
		$this->nof = count($this->fields);
		$this->primaryKey = "";



		
		for($i=0;$i<$this->nof;$i++)
		{
			//fix type and length
			$tp = explode("(",$this->fields[$i]['Type']);
			if(is_array($tp) && count($tp)>1)
			{
				$this->fields[$i]['Type'] = $tp[0];
				$this->fields[$i]['Length'] = str_replace(")","",$tp[1]);
			}
			else
			{
					$this->fields[$i]['Length'] = '';
			}
			if($this->fields[$i]['Length']=='')
				$this->fields[$i]['CRUD360_MAXLENGTH']=false;
			else
				$this->fields[$i]['CRUD360_MAXLENGTH']=$this->fields[$i]['Length'];	
			$this->fields[$i]['CRUD360_MINLENGTH']=false;
			$this->fields[$i]['CRUD360_FORMAT']='';
			$this->fields[$i]['CRUD360_FORMAT_TYPE']='';
			$this->fields[$i]['CRUD360_FORMAT_PREPOST']='';
			$this->fields[$i]['CRUD360_ENCRYPT']='';
			$this->fields[$i]['CRUD360_READONLY']=false;
			$this->fields[$i]['CRUD360_SUPRESS']=false;
			$this->fields[$i]['CRUD360_REQUIRED']=false;
			$this->fields[$i]['CRUD360_LINKED_TABLE']='';
			$this->fields[$i]['CRUD360_LINKED_TABLE_ID']='';
			$this->fields[$i]['CRUD360_LINKED_TABLE_TITLE']='';
			$this->fields[$i]['CRUD360_LINKED_TABLE_WHERE']='';
			$this->fields[$i]['CURD360_SOUNDS_LIKE_SEARCH']=true;			

			$this->fields[$i]['CURD360_EQUAL_SEARCH']=false;			

			$this->fields[$i]['CRUD360_LINKED_TABLE_WHERE_VALUES']='';
			$this->fields[$i]['CRUD360_CLIP_TEXT']=false;
			$this->fields[$i]['CRUD360_COLUMN_WIDTH']=false; //auto
			$this->fields[$i]['CRUD360_INPUT_EXT']='';
			$this->fields[$i]['CRUD360_IS_HTML']=false;
			$this->fields[$i]['CRUD360_INPUT_VALUE_ARRAY']='';
			$this->fields[$i]['CRUD360_RICH_TEXT']=false;
			$this->fields[$i]['CRUD360_SHOW_LENGTH']=true;
			$this->fields[$i]['CRUD360_CUSTOM_ATTRIB']='';
			$this->fields[$i]['CRUD360_DEFAULT']=$this->fields[$i]['Default'];
			if($this->guessTitle)
				$this->fields[$i]['CRUD360_TITLE']=ucwords(str_replace("_"," ",$this->fields[$i]['Field']));
			else
				$this->fields[$i]['CRUD360_TITLE']=$this->fields[$i]['Field'];
			$this->fields[$i]['CRUD360_PLACEHOLDER']=$this->fields[$i]['CRUD360_TITLE']."...";
			if($this->fields[$i]['Key'] =='UNI')
			{
				$this->required($this->fields[$i]['Field'],true);
				$this->setMinLength($this->fields[$i]['Field'],1);
			}
			$auto_inc = false;
			// Try to find a  "primary key with auto_increment" if system fails to find one, 
			// it will try to find a "primary key", if it fails to find a primary key again, it will simply try
			// to find a "unique key" (first one it encounters), or a primay key, 
			$original = "";
			if(self::$fieldOriginalTips==true)
			{
				$original = "`".$this->fields[$i]['Field']."` ";				
			}
			if($this->fields[$i]['Key']=='PRI' && $this->fields[$i]['Extra']=='auto_increment' && $this->primaryKey=="" && self::isBaseTable($table))
			{
				if($this->primaryKey=="")
				{
					$this->primaryKey = $this->fields[$i]['Field'];
				}
				$pktitle = str_replace($this->tableProcessIdentifier,"",$this->primaryKey);
				$pk_tooltip = "$original"."Selected As Pimary Key";
				if(strpos($this->primaryKey,$this->tableProcessIdentifier)!==false)
				{
					$pk_tooltip = "$original"."Crud360 Generated Primary Key!";
				}
				$this->fields[$i]['CRUD360_TITLE'] = "<span data-toggle='tooltip' title='$pk_tooltip'><u>".strtoupper($pktitle)."</u></span>";
					//strtoupper($this->fields[$i]['CRUD360_TITLE']);
				$auto_inc=true;
				$this->fields[$i]['CRUD360_PLACEHOLDER'] = strtoupper($pktitle)."...";
				$this->fields[$i]['CRUD360_READONLY'] = true;

			}
			else
			{
				$this->fields[$i]['CRUD360_TITLE'] = "<span data-toggle='tooltip' title='".$original."Field'>".$this->fields[$i]['CRUD360_TITLE']."</span>";
			}
			/*else
			{
				if($this->fields[$i]['Key']=='PRI' && $this->primaryKey=="")
				{
					if($this->primaryKey=="")
					{
						$this->primaryKey = $this->fields[$i]['Field'];
					}
					$this->fields[$i]['CRUD360_TITLE'] = "<u>".$this->fields[$i]['CRUD360_TITLE']."</u>";
					//strtoupper($this->fields[$i]['CRUD360_TITLE']);
				}
				else
				{
					if($this->fields[$i]['Key']=='UNI' && $this->primaryKey=="")
					{
						if($this->primaryKey=="")
						{
							$this->primaryKey = $this->fields[$i]['Field'];
						}
					$this->fields[$i]['CRUD360_TITLE'] = "<u>".$this->fields[$i]['CRUD360_TITLE']."</u>";
					//strtoupper($this->fields[$i]['CRUD360_TITLE']);
					}
				}
			}*/
			if(self::$supressPrimaryKeyAutoInc && $auto_inc==true)
				$this->supress($this->primaryKey,true);
			
			
			for($k=0;$k<$this->nof;$k++)
			{
				$this->allColumns[] = $this->fields[$k]['Field'];
			}
		}
		//var_dump(self::isBaseTable($table));
		if($this->primaryKey=="" && self::isBaseTable($table)==true)
		{
			self::primitiveMessage("<strong>Fatal Error:</strong> Your table `$table` doesn't have a primary key $pk_available with auto increment to be used by CRUD360, You must have a an 'int' type primary key with auto_increment to work with CRUD360. You can add a primary key with auto increment from your phpmyadmin / mysql console, however, if you want us to generate it for you, <a href='?".self::$crud360PkGenGet."=true'>Click Here</a> (Its safe, CRUD360 will simply add a primary key at the end of your field list).");
			exit();
		}
		//var_dump($this->fields);
		$this->autoTitle = true;
		$this->autoPlaceholder = true;
		//set current number of records
		//var_dump($table." ".$this->primaryKey);
		$stmt =  $DB->PDO->prepare("select * from `".$this->table."`");
		$stmt->execute();
		$this->nor = $stmt->fetchAll();
		$this->nor = count($this->nor);

	}
	
	
	public function tableHeader($value=true)
	{
		$this->tableHeader=$value;
	}

	public function getRow($id=0,$title='')
	{
		global $DB;
		$sql = "select * from `".$this->table."` where `".$this->primaryKey."` =:id";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute(["id"=>$id]);
		$row =  $stmt->fetchAll();
		if(!empty($row))
		{
			if($title=='')
				return $row;
			else
				return $row[0][$title];
		}
		else
			return false;
	}


	public function addNew($value=true)
	{
		$this->addNew=$value;
	}
	
	public function opWidth($value="")
	{
		self::$opWidth=$value;
	}
	public function noDeleteButton($value=false)
	{
		self::$noDeleteButton=$value;
	}

	public function search($value=true)
	{
		$this->search = $value;
	}
	
	public function paginationLinks($value=true)
	{
		$this->paginationLinks = $value;
	}

	//END OF CONSTRUCTOR
	public static function fieldOriginalTips($value=true)
	{
		self::$fieldOriginalTips = $value;
	}
	// Takes care of a scenario where a primary key with auto increment column field is missing
	public static function generatePkAutoIncKey($value = true)
	{
		self::$generatePkAutoIncKey = $value;
	}
	public function showFields()
	{
		var_dump($this->fields);
	}
	public static function namedColorToHexColor($color_name)
	{
    // standard 147 HTML color names
    $colors  =  array(
        'aliceblue'=>'F0F8FF',
        'antiquewhite'=>'FAEBD7',
        'aqua'=>'00FFFF',
        'aquamarine'=>'7FFFD4',
        'azure'=>'F0FFFF',
        'beige'=>'F5F5DC',
        'bisque'=>'FFE4C4',
        'black'=>'000000',
        'blanchedalmond '=>'FFEBCD',
        'blue'=>'0000FF',
        'blueviolet'=>'8A2BE2',
        'brown'=>'A52A2A',
        'burlywood'=>'DEB887',
        'cadetblue'=>'5F9EA0',
        'chartreuse'=>'7FFF00',
        'chocolate'=>'D2691E',
        'coral'=>'FF7F50',
        'cornflowerblue'=>'6495ED',
        'cornsilk'=>'FFF8DC',
        'crimson'=>'DC143C',
        'cyan'=>'00FFFF',
        'darkblue'=>'00008B',
        'darkcyan'=>'008B8B',
        'darkgoldenrod'=>'B8860B',
        'darkgray'=>'A9A9A9',
        'darkgreen'=>'006400',
        'darkgrey'=>'A9A9A9',
        'darkkhaki'=>'BDB76B',
        'darkmagenta'=>'8B008B',
        'darkolivegreen'=>'556B2F',
        'darkorange'=>'FF8C00',
        'darkorchid'=>'9932CC',
        'darkred'=>'8B0000',
        'darksalmon'=>'E9967A',
        'darkseagreen'=>'8FBC8F',
        'darkslateblue'=>'483D8B',
        'darkslategray'=>'2F4F4F',
        'darkslategrey'=>'2F4F4F',
        'darkturquoise'=>'00CED1',
        'darkviolet'=>'9400D3',
        'deeppink'=>'FF1493',
        'deepskyblue'=>'00BFFF',
        'dimgray'=>'696969',
        'dimgrey'=>'696969',
        'dodgerblue'=>'1E90FF',
        'firebrick'=>'B22222',
        'floralwhite'=>'FFFAF0',
        'forestgreen'=>'228B22',
        'fuchsia'=>'FF00FF',
        'gainsboro'=>'DCDCDC',
        'ghostwhite'=>'F8F8FF',
        'gold'=>'FFD700',
        'goldenrod'=>'DAA520',
        'gray'=>'808080',
        'green'=>'008000',
        'greenyellow'=>'ADFF2F',
        'grey'=>'808080',
        'honeydew'=>'F0FFF0',
        'hotpink'=>'FF69B4',
        'indianred'=>'CD5C5C',
        'indigo'=>'4B0082',
        'ivory'=>'FFFFF0',
        'khaki'=>'F0E68C',
        'lavender'=>'E6E6FA',
        'lavenderblush'=>'FFF0F5',
        'lawngreen'=>'7CFC00',
        'lemonchiffon'=>'FFFACD',
        'lightblue'=>'ADD8E6',
        'lightcoral'=>'F08080',
        'lightcyan'=>'E0FFFF',
        'lightgoldenrodyellow'=>'FAFAD2',
        'lightgray'=>'D3D3D3',
        'lightgreen'=>'90EE90',
        'lightgrey'=>'D3D3D3',
        'lightpink'=>'FFB6C1',
        'lightsalmon'=>'FFA07A',
        'lightseagreen'=>'20B2AA',
        'lightskyblue'=>'87CEFA',
        'lightslategray'=>'778899',
        'lightslategrey'=>'778899',
        'lightsteelblue'=>'B0C4DE',
        'lightyellow'=>'FFFFE0',
        'lime'=>'00FF00',
        'limegreen'=>'32CD32',
        'linen'=>'FAF0E6',
        'magenta'=>'FF00FF',
        'maroon'=>'800000',
        'mediumaquamarine'=>'66CDAA',
        'mediumblue'=>'0000CD',
        'mediumorchid'=>'BA55D3',
        'mediumpurple'=>'9370D0',
        'mediumseagreen'=>'3CB371',
        'mediumslateblue'=>'7B68EE',
        'mediumspringgreen'=>'00FA9A',
        'mediumturquoise'=>'48D1CC',
        'mediumvioletred'=>'C71585',
        'midnightblue'=>'191970',
        'mintcream'=>'F5FFFA',
        'mistyrose'=>'FFE4E1',
        'moccasin'=>'FFE4B5',
        'navajowhite'=>'FFDEAD',
        'navy'=>'000080',
        'oldlace'=>'FDF5E6',
        'olive'=>'808000',
        'olivedrab'=>'6B8E23',
        'orange'=>'FFA500',
        'orangered'=>'FF4500',
        'orchid'=>'DA70D6',
        'palegoldenrod'=>'EEE8AA',
        'palegreen'=>'98FB98',
        'paleturquoise'=>'AFEEEE',
        'palevioletred'=>'DB7093',
        'papayawhip'=>'FFEFD5',
        'peachpuff'=>'FFDAB9',
        'peru'=>'CD853F',
        'pink'=>'FFC0CB',
        'plum'=>'DDA0DD',
        'powderblue'=>'B0E0E6',
        'purple'=>'800080',
        'red'=>'FF0000',
        'rosybrown'=>'BC8F8F',
        'royalblue'=>'4169E1',
        'saddlebrown'=>'8B4513',
        'salmon'=>'FA8072',
        'sandybrown'=>'F4A460',
        'seagreen'=>'2E8B57',
        'seashell'=>'FFF5EE',
        'sienna'=>'A0522D',
        'silver'=>'C0C0C0',
        'skyblue'=>'87CEEB',
        'slateblue'=>'6A5ACD',
        'slategray'=>'708090',
        'slategrey'=>'708090',
        'snow'=>'FFFAFA',
        'springgreen'=>'00FF7F',
        'steelblue'=>'4682B4',
        'tan'=>'D2B48C',
        'teal'=>'008080',
        'thistle'=>'D8BFD8',
        'tomato'=>'FF6347',
        'turquoise'=>'40E0D0',
        'violet'=>'EE82EE',
        'wheat'=>'F5DEB3',
        'white'=>'FFFFFF',
        'whitesmoke'=>'F5F5F5',
        'yellow'=>'FFFF00',
        'yellowgreen'=>'9ACD32');

    $color_name = strtolower($color_name);
    if (isset($colors[$color_name]))
    {
        return ('#' . $colors[$color_name]);
    }
    else
    {
        return ($color_name);
    }

	}
	public static function readablecolor($bg){
		

		if(strpos($bg,"#")===0)
		{
		}
		else
		{
			$bg = self::namedColorToHexColor($bg);
		}
		
		$bg = str_replace("#","",$bg);
		
		if(strlen($bg)==3)
		{
			$a = str_split($bg);
			$bg = $a[0].$a[0].$a[1].$a[1].$a[2].$a[2];
			//var_dump($bg);
		}
		
		
		$r = hexdec(substr($bg,0,2));
		$g = hexdec(substr($bg,2,2));
		$b = hexdec(substr($bg,4,2));
	
		$contrast = sqrt(
			$r * $r * .241 +
			$g * $g * .691 +
			$b * $b * .068
		);
		
		
		if($contrast > 130){
			return '000000';
		}else{
			return 'FFFFFF';
		}
	}
	public function guessTitle($value = true)
	{
		
			$this->guessTitle = $value;
			for($i=0;$i<$this->nof;$i++)
			{
				if($this->guessTitle==true)
					$this->fields[$i]['CRUD360_TITLE']=ucwords(str_replace("_"," ",$this->fields[$i]['Field']));
				else
					$this->fields[$i]['CRUD360_TITLE']=$this->fields[$i]['Field'];
			}
		
	}
	public function html($field,$value = true)
	{
		
			for($i=0;$i<$this->nof;$i++)
			{
					if($field == $this->fields[$i]['Field'])
						$this->fields[$i]['CRUD360_IS_HTML']= $value;				
			}
		
	}
	public function soundsLikeSearch($field,$value = true)
	{
		
			for($i=0;$i<$this->nof;$i++)
			{
					if($field == $this->fields[$i]['Field'])
						$this->fields[$i]['CURD360_SOUNDS_LIKE_SEARCH']= $value;				
			}
		
	}

	public function equalSearch($field,$value = true)
	{
		
			for($i=0;$i<$this->nof;$i++)
			{
					if($field == $this->fields[$i]['Field'])
						$this->fields[$i]['CURD360_EQUAL_SEARCH']= $value;				
			}
		
	}



	public function getTableName ()
	{
		return $this->table;
	}
	//########################## SQL ORDER BY ####################################
	// sets order of records shown either ascending / decending
	public function order($value = 'desc')
	{
		$a = ['asc','ASC','desc','DESC'];
		if(in_array($value,$a))
		$this->sqlOrder = $value;
		else 
		$this->sqlOrder = 'desc';

	}
	//######################### Max Records Per Table ###########################
	// 
	public function paginate($value = 10)
	{
		$this->maxRecords = $value;
	}


	//########################## heading #########################################
	// Takes a numeric value and clips all text longer than supplied value in rows
	public function maskPasswords($value = true)
	{
		$this->maskPasswords = $value;
	}

	//########################## heading #########################################
	// Takes a numeric value and clips all text longer than supplied value in rows
	public function heading($value)
	{
		$this->tableTitle = $value;
	}

	//################## clipAllLongText #########################################
	// Takes a numeric value and clips all text longer than supplied value in rows
	public function clipAllLongText($value)
	{
		$this->clipAllLongText = $value;
	}
	//################## Get All Tables  With Type ###############################
	// Get names of all tables in an indexed array of current database
	public static function isBaseTable($table)
	{
		global $DB;
		$db_name = Config::$dbName;
		$sql = "show full tables";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$tables = $stmt->fetchAll();
		//var_dump($tables);
		if(empty($tables))
		{
			self::primitiveMessage("<strong>Fatal Error: </strong> Your database `".Config::$dbName."` dosen't have any table(s)");
			exit();
		}
			
		$list = [];
		
		for($i=0;$i<count($tables);$i++)
		{
			$type =($tables[$i][1]);
			$name =($tables[$i][0]);			
			if($name == $table)
			{
				if($type=='BASE TABLE')
				return true;				
			}
			
		}
		return false;
	}
	//################## allTables ###################################
	// Get names of all tables in an indexed array of current database
	public static function allTables()
	{
		global $DB;
		$db_name = Config::$dbName;
		$sql = "show tables";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$tables = $stmt->fetchAll();
		//var_dump($tables);
		if(empty($tables))
		{
			self::primitiveMessage("<strong>Fatal Error: </strong> Your database `".Config::$dbName."` dosen't have any table(s)");
			exit();
		}
		$list = [];
		for($i=0;$i<count($tables);$i++)
		{
			$list[]=($tables[$i][0]);
		}
		return $list;
	}
	//################## numTables ###################################
	public static function numTables()
	{
		global $DB;
		$db_name = Config::$dbName;
		$sql = "show tables";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$tables = $stmt->fetchAll();
		$list = [];
		for($i=0;$i<count($tables);$i++)
		{
			$list[]=($tables[$i][0]);
		}
		return count($list);
	}

	//########### computes md5 hash/name pairs for all tables ##################
	// computes table hashes for all tables from main database and stores in a 
	// static array for later use
	public static function storeTableHashes()
	{
		$array=[];
		$tables = self::allTables();
		for($i=0;$i<count($tables);$i++)
		{
			self::$crud360[Crud360::generateTableHash($tables[$i])] = $tables[$i];
			self::$crud360Keys[] = Crud360::generateTableHash($tables[$i]);
		}
	}
	public static function generateTableHash($table)
	{
		$all = self::allTables();
		if(in_array($table,$all))
		{
			//var_dump($all,$table);
			return md5(config::$dbName.$table);
		}
		else
		{
			return false;
		}
	}
	//############################ getTablePageHrefs ##############################
	// returns standard link for a table
	public static function getTablePageHref($table)
	{
		if(is_array(Crud360::$crud360))
		{
			$hash = self::generateTableHash($table);
			if($hash==false)
				return $_SERVER['PHP_SELF'];
			else
				return "?".Crud360::$crud360Get."=$hash";
		}
	}
	//############################## swapKeysVals #################################
	// swaps keys with values
	public static function keyExists($array)
	{
		if(is_array($array))
		{
			
		}
		return $array;
	}
	//############################## allTables #################################
	// Returns an indexed array with objects of all the database tables
	public static function allObjects()
	{
		
		$tables = self::allTables();
		$obj = [];
		for($i=0;$i<count($tables);$i++)
		{
			if(self::isBaseTable($tables[$i]))
			{
				$obj[] = new Crud360($tables[$i]);
			}
		}
		//var_dump($obj);
		return $obj;
	}

	public static function allMagic($objects)
	{
		for($i=0;$i<count($objects);$i++)
		{
				$objects[$i]->magic();
		}

	}
	public static function source($value= true)
	{
		self::$showSource = $value;
	}

	public function getIdentifier ()
	{
		return $this->tableProcessIdentifier;
	}
	public function formHeading($value= true)
	{
		$this->formHeading = $value;
	}
	public function maxVal($field='')
	{
		if($field=='')
			$field = $this->primaryKey;
		global $DB;
		$table = $this->table;
		$sql = "select max(`$field`) 'maxVal' from `$table`";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll();
		if($row!=false)
			return $row[0]['maxVal']; 
	}

	public function minVal($field)
	{
		if($field=='')
			$field = $this->primaryKey;
		global $DB;
		$table = $this->table;
		$sql = "select min(`$field`) 'minVal' from `$table`";
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll();
		if($row!=false)
			return $row[0]['minVal']; 

	}


	public function addFormTpl($tpl='')
	{
		//var_dump($tpl);
		$this->addFormTpl = $tpl;
	}
	public function recordTpl($tpl='',$keys=false)
	{
		//var_dump($tpl);
		$this->recordTpl = $tpl;
		$this->recordKeys = $keys;		
	}

	public function where($where,$where_values)
	{
		$this->whereClause = $where;
		if(!is_array($where_values))
			$where_values = array();
		$this->whereClauseValues = $where_values;
	}

	public function tableTitle($value)
	{
		$this->tableTitle = $value;
	}
	

	public function clipLongText($field='',$value=100)
	{
		if($field=='*' || $field=='all')
		$field='';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_CLIP_TEXT']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_CLIP_TEXT']=$value;
				return;
			}
			
		}
	}
	public function width($field='',$value="10%")
	{
		if($field=='*' || $field=='all')
		$field='';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_COLUMN_WIDTH']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_COLUMN_WIDTH']=$value;
				return;
			}
			
		}
	}
	public static function primitiveMessage($msg,$title='')
	{?>
    	<div style="width:1170px; padding:15px; margin:0 auto">
        <p style="
        font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size:15px; border:1px solid #AD1214; border-radius:15px;
        padding:30px 15px; text-align:center; margin-top:50px; color:#AD1214"><span><?=$title?></span><?=$msg?></p></div>
	<?php	
	}
	public function columns($value)
	{

		for($i=0;$i<count($value);$i++)
		{
			if(!in_array($value[$i],$this->allColumns))
			{
				$clm = $value[$i];
				self::primitiveMessage("<strong>Fatal Error:</strong> The column name `$clm` is not found in your database ".Config::$dbName);
				exit();
			}
		}
		
		$this->columns = $value;
	
		
	}

	public function editTimestamp($value= true)
	{
		$this->editTimestamp = $value;
	}

	public function recordHeading($value= true)
	{
		$this->recordHeading = $value;
	}
	public function modalForm($value= true)
	{
		$this->modalForm = $value;
	}

	//Show field length against title of forms or not, leaving all empty shows all lengths
	public function titleLength($field='',$value=true)
	{
		if($field=='*' || $field=='all')
			$field='';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_SHOW_LENGTH']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_SHOW_LENGTH']=$value;
			}
			
		}
	}

	public function setMinLength($field='',$value)
	{
		if($field=='*' || $field=='all')
			$field='';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_MINLENGTH']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_MINLENGTH']=$value;
			}
			
		}
	}
	public function setMaxLength($field='',$value)
	{
		if($field=='*' || $field=='all')
			$field='';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_MAXLENGTH']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_MAXLENGTH']=$value;
			}
			
		}
	}


	public function richText($field='',$value=true)
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_RICH_TEXT']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_RICH_TEXT']=$value;
			}
		}
	}
	
	public function required($field='',$value=true)
	{
		if($field=='*' || $field=='all')
			$field = '';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_REQUIRED']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_REQUIRED']=$value;
			}
		}
	}

	public function readonly($field='',$value=true)
	{
		if($field=='*' || $field=='all')
			$field = '';
		for($i=0;$i<$this->nof;$i++)
		{
			if($field!='')
			{
				if($this->fields[$i]['Field']==$field)
				{
					$this->fields[$i]['CRUD360_READONLY']=$value;
					return;
				}
			}
			else
			{
				$this->fields[$i]['CRUD360_READONLY']=$value;
			}
		}
	}


	//user empty string '', '*', 'all' to select all, set true to hide fields in either forms or records . true supresses, false unsupresses, use array to supress/unsupress fields.
	public function supress($field='',$value=true,$other_opposite=false)
	{
		if($field =='all')
			$field = '';
		if($field == '*')
			$field = '';
		for($i=0;$i<$this->nof;$i++)
		{
			
			if(!is_array($field))
			{		
				if($field!='')
				{
					if($this->fields[$i]['Field']==$field)
					{

						$this->fields[$i]['CRUD360_SUPRESS']=$value;
						$this->supressedTotal++;
					
					}
					else
					{
						if($other_opposite)
						{
							$this->fields[$i]['CRUD360_SUPRESS']=!$value;
														
						}
					}
				}
				else
				{
					$this->fields[$i]['CRUD360_SUPRESS']=$value;
				}
			}
			else
			{
					
					if(in_array($this->fields[$i]['Field'],$field))
					{
						$this->fields[$i]['CRUD360_SUPRESS']=$value;
						$this->supressedTotal++;
						
					}
					else
					{
						if($other_opposite)
						{
							$this->fields[$i]['CRUD360_SUPRESS']=!$value;
						}
					}


			}
		}
	}
	public function setEncrypt($field,$value='md5')
	{

		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_ENCRYPT'] = $value;
				//var_dump($this->fields[$i]);
				return;
			}
		}

	}

	//override existing fieldtype or custom one to be used anywhere, most common use is checkbox & radio to convert existing auto generated drop downs with radio or check boxes
	public function setInputType($field,$type,$values='')
	{
		
		$allowed = ["text","number","tel","email","password","checkbox","radio"];
		if(!in_array($type,$allowed))
			$type = "text";

		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{

				$this->fields[$i]['CRUD360_INPUT_EXT']=$type;
				$this->fields[$i]['CRUD360_INPUT_VALUE_ARRAY']=$values;
				//var_dump($this->fields[$i]);
			}
		}
		//exit();

	}
	//add and load dynamically generated JS
	public function addJs($newJs)
	{
		$this->js.=$newJs;
	}
	public function loadJs()
	{
		echo $this->js;
	}
	public function delete($id=0)
	{
		
		
			$id_field = $this->primaryKey;
		global $DB;
		$table = $this->table;
		$sql = "delete from `$table` where $id_field=:id";
		try{
			
			$stmt = $DB->PDO->prepare ($sql);
			$success = $stmt->execute(["id"=>$id]);
		}
		catch (PDOException $e) {
			$code = $e->getCode();
			
			$msg = "Cannot delete a parent record! ";
			if($code==23000)
				$msg.=$e->getMessage();
			else
				$msg =  $e->getMessage();

				if(Config::$pdoVerbose)
					$this->lastMsg = "<div class='alert alert-danger'>$msg</div>";
				else
					$this->lastMsg = "<div class='alert alert-danger'>Failed adding a record. ".$e->errorInfo[2]."</div>";	
			$this->lastMsg();
			return false;
		}
		if($success)
		{
			$this->lastMsg();
			echo 'true';
		}
	}
	//Sets auto generated titles to true or false
	public function autoTitle($value=true)
	{
		$this->autoTitle=$value;	
	}
	public function showSerial($value=true)
	{
		$this->recordSerial=$value;	
	}

	public function autoRequired($value=true)
	{
		$this->autoRequired=$value;	
	}
	//sets property weather to show placeholders or not
	public function autoPlaceholder($value=true)
	{
		$this->autoPlaceholder=$value;	
	}
	public function getFieldInfo($field)
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				//var_dump($this->fields[$i]);

				return $this->fields[$i];
			}
		}

	}
	public function showFieldsInfo()
	{
		var_dump($this->fields);
		
	}
	public function getPk ($full=false,$structured = false)
	{
		$st = "";
		if($structured==true)
			$st="`";
		if($full==true)
			return $st.$this->table."$st.$st".$this->primaryKey.$st;
		else
			return $st.$this->primaryKey.$st;
	}
	//Choose a custom field title for forms or table headings	
	public function title($field,$new_title)
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_TITLE']=$new_title;
				return true;
			}
		}
	}
	//Choose a custom field title for forms or table headings	
	public function placeholder($field,$new_placeholder)
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_PLACEHOLDER']=$new_placeholder;
				return true;
			}
		}
	}

	//set an initial or in processing default feild values, also sets default values in dropdowns
	public function setDefault ($field,$value)
	{
		
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_DEFAULT']=$value;
			}
		}


	}
	//displays a single field 
	public function renderField($field, $classes = "",$update_value='',$update=false)
	{
	
		//var_dump($this->getFieldInfo($field));
		if($update)
		$update_postfix = "_update";
		else
		$update_postfix = "";

			
		//if($this->table=='countries')
		//	var_dump($this->primaryKey,$update_value);
					
		$fieldInfo = $this->getFieldInfo($field);
		//var_dump($fieldInfo);
		$type = $fieldInfo['Type'];
		$length = $fieldInfo['Length'];
		$name = $fieldInfo['Field'];
		$title = $fieldInfo['CRUD360_TITLE'];
		$custom_attrib = $fieldInfo['CRUD360_CUSTOM_ATTRIB'];
		$show_length = $fieldInfo['CRUD360_SHOW_LENGTH'];
		if($show_length)
		{
			if($length!='' && $type!='text')
				$title.= " ($length)";
				
		}
		$required = false;
		
		$redstar = "<span class='title-required'>*</span>";
		$db_required = $fieldInfo['Null'];
		//var_dump($fieldInfo['Null']);
		if($db_required =='NO')
			$db_required = true;
		else
			$db_required = false;
		//var_dump($db_required);
		$sys_required = $fieldInfo['CRUD360_REQUIRED'];
		
		
		
		$required1 = false;
		$required2 = false;
		
		if($this->autoRequired)
		{
			$required1 = $db_required;
		}
		if($sys_required)
		{
			$required2 = $sys_required;	
		}
		if($required1 || $required2)	
			$required = true;
		else
			$required = false;
		
		
		
		
		$supress = $fieldInfo['CRUD360_SUPRESS'];
		$default = $fieldInfo['CRUD360_DEFAULT'];
		
		if($update==true)
			$default = $update_value;
		
		if($fieldInfo['CRUD360_INPUT_EXT']=='password')
		{
			$default = "";
			$required = false;
		}

		$update_start_date= "";
		
		if($fieldInfo['Type']=='date')
		{
			$default = self::formatValue($default,"date","m/d/Y");
		}
		

		if($fieldInfo['Type']=='datetime' || $fieldInfo['Type']=='timestamp')
		{
			$default = self::formatValue($default,"date","m/d/Y h:i A");
		}
		
		
		if($required)
		{
			$required="required='required'";
			$title.=" ".$redstar;
		}
		else
		{
			$required = "";
		}
			
		
		$custom_attrib.=" ".$required;
		
		$timepicker_timestamp = true;
		
		if($fieldInfo['CRUD360_READONLY']==true || $fieldInfo['Type']=='timestamp' && $this->readOnlyTimestamps==true )
		{
			$custom_attrib.=" readonly='readonly'";	
			$timepicker_timestamp = false;
		}
		
		
		
		$placeholder = $fieldInfo['CRUD360_PLACEHOLDER'];
		$rich = $fieldInfo['CRUD360_RICH_TEXT'];

		//overrides
		$minlength = $fieldInfo['CRUD360_MINLENGTH'];
		$maxlength = $fieldInfo['CRUD360_MAXLENGTH'];
		$all_length = "";
		
		if($minlength)
			$all_length.=" minlength='$minlength' ";
		if($maxlength)
			$all_length.=" maxlength='$maxlength' ";

		if($classes == "")
		{
			$classes = "form-control ".$this->table."_$field";
		}


		$input_name = "tbl_".$this->tableProcessIdentifier."_clm_".$name.$update_postfix;
		
		
		if($fieldInfo['CRUD360_FORMAT_TYPE']!='')
		{
				//var_dump($fi);
			$format_type = $fieldInfo['CRUD360_FORMAT_TYPE'];
			$format_pattern = $fieldInfo['CRUD360_FORMAT'];
			$format_prepost = $fieldInfo['CRUD360_FORMAT_PREPOST'];
			
			if($format_type=='date')
				$default = self::formatValue($default,$format_type,$format_pattern,$format_prepost);
		}

		$start_date="+1971/05/01";
		if($fieldInfo['Type']=='date')
		{
			$start_date = $default;
		}
		
		
		if(!$supress)
		{
			
			$label = "";
			if($this->autoTitle==true)
				$label = "<label for='$input_name'>$title</label>";
			if($this->autoPlaceholder==false)
				$placeholder = "";
			
			
			if($fieldInfo['CRUD360_INPUT_EXT']!='checkbox' && $fieldInfo['CRUD360_INPUT_EXT']!='radio' && $fieldInfo['CRUD360_INPUT_EXT']!='select' && $fieldInfo['CRUD360_INPUT_EXT']!='file')
			{
				if($fieldInfo['CRUD360_LINKED_TABLE']=='' && $fieldInfo['CRUD360_LINKED_TABLE_ID']=='' && $fieldInfo['CRUD360_LINKED_TABLE_TITLE']=='')
				{	
					if($length>=256)
						$type = 'text';

					if($fieldInfo['CRUD360_INPUT_EXT']=='text')
						$type = 'varchar';

					if($fieldInfo['CRUD360_INPUT_EXT']=='textarea')
						$type = 'text';
					switch($type)
					{
						case "varchar": 	{
							//if($fieldInfo['Field']=='password')
							//	echo "YES";
							$vctype = "text";
							//echo $fieldInfo['CRUD360_INPUT_EXT'];
							
							if($fieldInfo['CRUD360_INPUT_EXT']!='')
								$vctype = $fieldInfo['CRUD360_INPUT_EXT'];	
							//var_dump($fieldInfo);
							echo "$label<input $custom_attrib type='$vctype' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default' $all_length>";	 
							break;
						
						}
						case "datetime": 	
						{	
							$this->js .= "\n$('#id_$input_name').datetimepicker({
									mask:'19/39/9999 29:59',
									formatTime:'g:i A', 
									format: 'm/d/Y h:i A',
									startDate:'$start_date'
									});
							";
							$this->js .= "\n
							$('body').on('focus','#id_$input_name"."_update"."', function(){
								$(this).datetimepicker({
									formatTime:'g:i A', 
									format: 'm/d/Y h:i A',
									defaultDate:'$start_date'
									});
							})";

							echo "$label<input $custom_attrib type='text' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>";	 
							break;
						}
						case "timestamp": 	
						{	
							
							if($timepicker_timestamp)

							{
								$this->js .= "\n$('#id_$input_name').datetimepicker({
										mask:'19/39/9999 29:59',
										formatTime:'g:i A', 
										format: 'm/d/Y h:i A',
									
										startDate:'$start_date'
										});
								";
								
								$this->js .= "\n
								$('body').on('focus','#id_$input_name"."_update"."', function(){
									$(this).datetimepicker({
										formatTime:'g:i A', 
										format: 'm/d/Y h:i A',
									
										defaultDate:'$start_date'
										});
								})";
							}

							
							
							echo "$label<input $custom_attrib type='text' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>";	 
							break;
						}
						
						case "date":		
						{	
							$this->js .= "\n$('#id_$input_name').datetimepicker({
									mask:'19/39/9999 ',
									format: 'm/d/Y',
									timepicker:false,
									startDate:'$start_date'
									});
							";
							$this->js .= "\n
							$('body').on('focus','#id_$input_name"."_update"."', function(){
								$(this).datetimepicker({
									format: 'm/d/Y',
									timepicker:false,
									defaultDate:'$start_date'
									});
							})";


							echo "$label<input $custom_attrib type='text' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>";	 
							break;
						}
						
						
						case "int": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "float": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "double": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "decimal": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "tinyint": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "smallint": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "mediumint": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}
						case "bigint": 		{	echo "$label<input $custom_attrib type='number' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default'>"; 	 break;

						}

						case "text": 		
						{	
							if($rich)
							{

								$this->js .= 
							"\n$('#id_$input_name').html('$default').tinymce({
							theme: 'modern',
							plugins: [
								'advlist autolink lists link image charmap print preview hr anchor pagebreak',
								'searchreplace wordcount visualblocks visualchars code fullscreen',
								'insertdatetime media nonbreaking save table contextmenu directionality',
								'emoticons template paste textcolor colorpicker textpattern imagetools codesample code'
							],
							content_css: [
								'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
								'//www.tinymce.com/css/codepen.min.css'
							],
							menubar: 'tools',
								toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
								toolbar2: 'print preview media | forecolor backcolor emoticons | codesample code'
							});";
							}
							
							echo "$label<textarea $custom_attrib name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes'>$default</textarea>"; 
							break;
						}
						default : 			{	echo "$label<input $custom_attrib type='text' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default' $all_length>"; 	 break;}
					}
				}
				else
				{
					$lookup = $this->getLookupValues($fieldInfo);
					
						echo "$label<select $custom_attrib name='$input_name' id='id_$input_name' class='$classes'>";
						$selected = "";
						
						if($placeholder!='' && !$fieldInfo['CURD360_REQUIRED']==false)
							echo "<option value=''>$placeholder</option>";
						
						for($i=0;$i<count($lookup);$i++)
						{
							if($fieldInfo['CRUD360_INPUT_EXT']!='text')
							{
								if($default == $lookup[$i]['id'])
								$selected = "selected='selected'";
								else
									$selected = "";
								echo "<option $selected value='".$lookup[$i]['id']."'>".$lookup[$i]['title']."</option>";
							}
							else
							{
								if($default == $lookup[$i]['id'])
								{
									$selected = "selected='selected'";
									echo "<option $selected value='".$lookup[$i]['id']."'>".$lookup[$i]['title']."</option>";
								}

							}
						}
						echo "</select>";	
					//var_dump($lookup);
				}
			}
			else
			{
				$new_type = $fieldInfo['CRUD360_INPUT_EXT'];
							//var_dump($fieldInfo);
				if($new_type=='file')
				{
					echo "$label<input $custom_attrib type='file' name='$input_name' id='id_$input_name' placeholder='$placeholder' class='$classes' value='$default' $all_length>";
					return true;
				}
				if($new_type!='select')
				{
					$classes = str_replace("form-control","",$classes);
					if($fieldInfo['CRUD360_LINKED_TABLE']=='' && $fieldInfo['CRUD360_LINKED_TABLE_ID']=='' && $fieldInfo['CRUD360_LINKED_TABLE_TITLE']=='' && $fieldInfo['CRUD360_INPUT_VALUE_ARRAY']=='')
					{	
							$label = "
							<div class='$new_type'>
							<label for='$input_name'><input $custom_attrib type='$new_type' name='$input_name"."[]"."' id='id_$input_name' value='$default' class='$classes'>$title</label></div>";
							echo $label;
	
	
					}
					else
					{
						echo "<div style='font-weight:bold'>$title</div>";
	
						$lookup = $this->getLookupValues($fieldInfo);
						if(is_array($fieldInfo['CRUD360_INPUT_VALUE_ARRAY']))
							$lookup = $fieldInfo['CRUD360_INPUT_VALUE_ARRAY'];
						
						//var_dump( $fieldInfo['CRUD360_INPUT_VALUE_ARRAY']);
						
						echo "<div class='row'>";
						for($i=0;$i<count($lookup);$i++)
						{
							$label = "
							
							<div class='col-md-6'><div class='$new_type'>
							<label for='$input_name"."[]"."'><input $custom_attrib type='$new_type' name='$input_name"."[]"."' id='id_$input_name' value='".$lookup[$i]['id']."' class='$classes'>".$lookup[$i]['title']."</label></div></div>";
							echo $label;
						}
						echo "</div>";
					}
				}
				else
				{
					
					//var_dump($fieldInfo);
					$lookup = $this->getLookupValues($fieldInfo);
					if(empty($lookup) && !empty($fieldInfo['CRUD360_INPUT_VALUE_ARRAY']) && is_array($fieldInfo['CRUD360_INPUT_VALUE_ARRAY']))
						$lookup = $fieldInfo['CRUD360_INPUT_VALUE_ARRAY'];
					//var_dump($lookup);
					
					if(!empty($lookup))
					{	
						echo "$label<select $custom_attrib name='$input_name' id='id_$input_name' class='$classes'>";
						$selected = "";
						
					if($placeholder!='' && $fieldInfo['CURD360_REQUIRED']==false)
							echo "<option value=''>$placeholder</option>";
						
						for($i=0;$i<count($lookup);$i++)
						{
							if($default == $lookup[$i]['id'])
								$selected = "selected='selected'";
							else
								$selected = "";
							echo "<option $selected value='".$lookup[$i]['id']."'>".$lookup[$i]['title']."</option>";
						}
						echo "</select>";	
					}
					
					
					
				}
			}
			
			
		}
		echo "";
	}
	//add custom html attributes to further modify html input elements such as "style='padding:0px' data-id=5" so on and so forth
	public function setCustomAttrib($field,$attribs)
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_CUSTOM_ATTRIB']=$attribs;
			}
		}
	}
	//if there's a linked table, get its title field alongwith the std id value identifier
	public function getLookupValues($fieldInfo)
	{
		//var_dump($fieldInfo);
		global $DB;
		$table = $fieldInfo['CRUD360_LINKED_TABLE'];
		$id = $fieldInfo['CRUD360_LINKED_TABLE_ID'];
		$title= $fieldInfo['CRUD360_LINKED_TABLE_TITLE'];
		$where = $fieldInfo['CRUD360_LINKED_TABLE_WHERE'];
		$where_values= $fieldInfo['CRUD360_LINKED_TABLE_WHERE_VALUES'];
		
		try {
			if(empty($where) || empty($where_values))
			{
				$sql = "select $id,$title 'title' from $table where 1";
				
				
				$stmt = $DB->PDO->prepare($sql);
				$stmt->execute();
	
			}
			else
			{
				$sql = "select $id,$title 'title' from $table where $where";
				
				
				$stmt = $DB->PDO->prepare($sql);
				$stmt->execute($where_values);
				return $stmt->fetchAll();
	
			}
			return $stmt->fetchAll();
		}catch (PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}

		return false;
	}
	//set lookup fields with required settings, field in current table, pointed to table, value identifier column, title fields (can be a single field or use concat to create your own version of lookup display values
	public function setLookupFields($field,$table,$id,$title_fields,$where='',$where_values='')
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_LINKED_TABLE']=$table;
				$this->fields[$i]['CRUD360_LINKED_TABLE_ID']=$id;
				$this->fields[$i]['CRUD360_LINKED_TABLE_TITLE']=$title_fields;
				$this->fields[$i]['CRUD360_LINKED_TABLE_WHERE']=$where;
				$this->fields[$i]['CRUD360_LINKED_TABLE_WHERE_VALUES']=$where_values;
				//var_dump($this->fields[$i]['CRUD360_LINKED_TABLE_WHERE_VALUES']);
				return;
			}
		}
	}
	public function getFullRow($id)
	{
		global $DB;
		$pk = $this->primaryKey;
		$sql = "select * from `".$this->table."` where $pk=:id";
		
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute(["id"=>$id]);
		$row = $stmt->fetchAll();
		if(!empty($row))
			return $row[0];
		else
			return false;
	}
	
	public function renderTypeFields($inputs,$type='',$update)
	{
		//echo "<div class='col-md-12'>$type</div>";
		$allwidth=0;
		$elements = 0;
		$total = count($inputs);
		switch ($type)
		{
			case "text": { 
							if($update) $width=12; else $width=12; break;
				}
			default: { 
				
					if($update) $width=3; else $width=6; break;		
				/*if($total/6==0 && count($inputs)/3!=0 && count($inputs)/2!=0) //3, 9
				{
					
				}
				if(count($inputs)/4==0 && count($inputs)/3!=0 && count($inputs)/2!=0) //3, 9
				{
					if($update) $width=3; else $width=6; break;	
				}
				
				if(count($inputs)/3==0 && count($inputs)/2!=0) //3, 9
				{
					if($update) $width=3; else $width=6; break;
				}
				if(count($inputs)/2==0)
				{
					if($update) $width=4; else $width=4; break;
				}*/
				
			}
		}
		/*foreach($inputs as $key=>$val)
		{
			for($k=0;$k<count($val);$k++)
			{
					$allwidth+= $width;
					$elements++;
					
			}
		}*/
		//echo "<div class='col-md-12'>$allwidth/$elements</div>";
		
		//echo "<div class='col-md-12'>($width)</div>";
		
		$available = $this->formSpace;
		
				
		foreach($inputs as $key=>$val)
		{
			
			for($k=0;$k<count($val);$k++)
			{
					
						echo "<div class='afs col-md-$width'>";
						echo $val[$k][0];
						echo "</div>";
					
			}
		}

	}

	public function autoFormStructure($structure,$update=false)
	{
		
		$element = $structure['element'];
		$length = $structure['length'];
		$type = $structure['type'];
		$name = $structure['name'];

		$inputs = array();
		$max = count($element);
		
		for($i=0;$i<$max;$i++)
		{
			$inputs[$type[$i]][] = array($element[$i],$length[$i],$name[$i]);
		}


		if(isset($inputs['int']))
		{
			$int = $inputs['int'];
			
			/*$pkelement = false;		
			for($p =0;$p<count($int);$p++)
			{
				var_dump($int);
				$fi = $this->getFieldInfo($int[$p][2]);
				$pkai = ($fi['Key']=='PRI' && $fi['Extra']='auto_increment')?true:false;
				if($pkai)
				{
					$pkelement = $int[$p];
					unset($int[$p]);
				}
			}
			$newint = false;
			
			
			if($pkelement!=false)
			{
				$newint[]=$pkelement;
				for($k=0;$k<count($int);$k++)
				{
					$newint[] = $int[$k];
				}
				$int = $newint;
			}*/
			
			unset($inputs['int']);
			$this->renderTypeFields([$int],'int',$update);
		}
		
		if(isset($inputs['varchar']))
		{
			$varchar = $inputs['varchar'];
			unset($inputs['varchar']);
			$this->renderTypeFields([$varchar],'varchar',$update);
		}

		if(isset($inputs['date']))
		{
			$date = $inputs['date'];
			unset($inputs['date']);
			$this->renderTypeFields([$date],'date',$update);
		}

		if(isset($inputs['datetime']))
		{
			$datetime = $inputs['datetime'];
			unset($inputs['datetime']);
			$this->renderTypeFields([$datetime],'datetime',$update);
		}
		if(isset($inputs['timestamp']))
		{
			$timestamp = $inputs['timestamp'];
			unset($inputs['timestamp']);
			$this->renderTypeFields([$timestamp],'timestamp',$update);
				
		}
		if(isset($inputs['text']))
		{
			$text = $inputs['text'];
			unset($inputs['text']);
			$this->renderTypeFields([$text],'text',$update);
		}
		if(!empty($inputs))
			$this->renderTypeFields($inputs,'',$update);

		echo "<div class='clearfix'></div>";
		//var_dump($big);
		
		//int, varchar, date, text, datetime, anything else
		
		/*for($i=0;$i<$max;$i++)
		{
			$w = $width[$i];
			if($type[$i]=='int')
			{
				
				echo "<div class='col-md-$w'>";
				echo $element[$i];
				echo "</div>";
			}
		}*/
	}
	public static function renderSource($file)
	{
		self::$showSource = true;
		if(self::$showSource)
		{
			echo "<h6 style='margin:0'>File: $file</h6><div class='source'>";
			htmlentities(highlight_string(file_get_contents($file)));
			echo "</div>";
		}
	}
	//render complete form, by default form shows up in ADD mode, setting update to true will generate update mode form
	//if there's a tpl file in the tpl folder, use it it can also be used to choose which fields to show and which fields to hide, 
	//if tpl doesn't have all the fields, system tries to set defaults to non rendered field's corresponding db column.
	//if there's no such file, system will load standard form, with all the "unspressed" fields.
	// to see how tpl files work, open tpl folder and see for your self, they're easy! wherever a field name is specified in 
	// {(field)} format, its replaced by actual field, since our system uses bootsrap, you are adviced to use bootstrap grid system
	// to format your forms.
	public function renderAddButton()
	{
		echo $this->addButton;
	}
	public function renderForm($modal=false,$update=false,$id=0)
	{
		
		$autoFormStructure = array();
		$show_title=$this->formHeading;
		$submit=true;
		$title=true;
		$current_data = false;

		if($id!=0 || $id!='')
		{
		//var_dump($id!=0 || $id!='');

			$current_data = $this->getFullRow($id);
		

		}
		
		
		$id_field = "";
		if($current_data)
			$id_field = "<input type='hidden' name='".$this->table."_id_hidden' value='$id'>";
		
		$update_identifier = "";
		
		if($current_data)
			$update_identifier = "_update";
		
		$method = $this->method;
		if($modal==true)
			$modal = "modal";
		else
			$modal = "nomodal";
		if($title)
		{
			$title = $this->tableTitle;
		}

		if($update)
		{
			$updateid = "_update";
			$title .=" : Update";
			$btntext = "Update";
		}
		else
		{
			
			$titleForm = "";
			if($this->formHeading)
				$titleForm = $this->tableTitle;
			
			$updateid = "";	
			if($modal=='modal' && !isset($_GET['ajax']) && $this->tableHeader)
			{
				echo "<div class='add-button'>
					<div class='row'>
						<div class='col-md-6'>
							<h4>$titleForm</h4>
						</div>
						<div class='col-md-4' style='text-align:right'>";
							
						if($this->search) echo "<div class='row'>
								<div class='col-md-8 col-xs-8'>
								<input type='text' placeholder='Search Filter...' class='form-control search-filter' id='".$this->tableProcessIdentifier."-search-query' name='id='".$this->tableProcessIdentifier."_search_query''>				</div>
								<div class='col-md-4 col-xs-4'>
									<button data-tbl='".$this->tableProcessIdentifier."' data-qs='".$_SERVER['QUERY_STRING']."' class='pagination-trigger btn btn-info pull-right search-filter-button' data-id='records_".$this->tableProcessIdentifier."_div' id='".$this->tableProcessIdentifier."-search-button'  data-limit='0'>Apply</button>
								</div>
							</div>";
							
							
					echo "		
						</div>
						
						<div class='col-md-2 add-button-body'>";
					
					if($this->addNew) echo  "		<button data-toggle='$modal' data-target='#".$this->tableProcessIdentifier."_table_modal'  data-qs='".$_SERVER['QUERY_STRING']."' class='btn btn-primary pull-left '>Add New</button>";
					
					echo "
							</div>
						</div>
				</div>";
			}
			$this->addButton = 	"<button data-toggle='$modal' data-target='#".$this->tableProcessIdentifier."_table_modal'  data-qs='".$_SERVER['QUERY_STRING']."' class='btn btn-primary pull-left '>Add New</button>"
;
			$title .=" : Add New ";
			$btntext = "Add New";
			
		}
		$modal_id = $this->tableProcessIdentifier."_table_modal".$updateid;
		$identifier = "<input type='hidden' name='".$this->tableProcessIdentifier."$update_identifier' value='true'>";
//		var_dump("crud360/tpl/".$this->tpl.".php");
		if($this->addFormTpl!='' && file_exists("crud360/tpl/addform/".$this->addFormTpl.".php"))
		{
			ob_start();
			include("crud360/tpl/addform/$this->table.php");
			$html = ob_get_clean()."<div class='clearfix'></div>";
		}
		else
			$html = "";
		$final_html = $html;
		//var_dump($final_html);
		?>
         <?php
			if($update==true)
				$action='update';
			else
				$action='add';
		?>

        <div class="<?=$modal?>" id="<?=$modal_id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     	  <form	data-records='<?="records_".$this->tableProcessIdentifier."_div"?>' data-tbl='<?=$this->tableProcessIdentifier?>' data-id='<?=$id?>' data-action='<?=$action?>'
          
           class="ajax-form" method='<?=$method?>' enctype="multipart/form-data" name='<?=$this->tableProcessIdentifier."_table"?>' id='<?=$this->tableProcessIdentifier."_table"?>'>
          <div class="<?=$modal?>-dialog">
            <div class="<?=$modal?>-content">
              <div class="<?=$modal?>-header">
                <?php if($modal=='modal') { ?>
                <button type="button" class="close" data-dismiss="<?=$modal?>" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php } ?>
                <div class="col-md-12"><h4 class="<?=$modal?>-title"><?=$title?></h4></div>
                
              </div>
              	<div class="<?=$modal?>-body">
              		<?=$identifier?>
                    <?php
					if($current_data)
						echo $id_field;
                    
					$ei = 0;
					
					
					for($i=0;$i<$this->nof;$i++)
					{

						if($current_data)
						{
								$update_value = $current_data[$this->fields[$i]['Field']];
						}
						else
							$update_value = "";

						if($html!="")
						{
							$field_find = "{(".$this->fields[$i]['Field'].")}";
							//var_dump($field_find);
							ob_start();
							
							if($current_data)
								$this->renderField($this->fields[$i]['Field'],"",$update_value,true);
							else
								$this->renderField($this->fields[$i]['Field'],"");
							$input = ob_get_clean();
							//var_dump($input);
							$final_html = str_replace($field_find,$input,$final_html);
						}
						else
						{
							if($this->fields[$i]['CRUD360_SUPRESS']==true)
								continue;
							
							$current_input = "";
							
						
							if($current_data)
							{
								ob_start();
								$this->renderField($this->fields[$i]['Field'],"",$update_value,true);
								$current_input.= ob_get_clean();
							}
							else
							{	
								ob_start();
								$this->renderField($this->fields[$i]['Field'],"");
								$current_input.= ob_get_clean();
							}
							
							if($this->autoFormStructure==true)
							{
								$autoFormStructure['name'][$ei]= $this->fields[$i]['Field'];
								$autoFormStructure['element'][$ei]= $current_input;							
								$autoFormStructure['length'][$ei]= $this->fields[$i]['Length'];
								$autoFormStructure['type'][$ei]= $this->fields[$i]['Type'];
								$ei++;

							}
							else
								echo $current_input;
						}
					}
					if($html!="")
					{
							echo $final_html;
					}
					else
					{
						$this->autoFormStructure($autoFormStructure,$update);
					}
					
						
					
					?>
                </div>
              	<div class="<?=$modal?>-footer">

                	<?php if($modal=='modal') {?>
                    <button type="button" name='<?=$this->tableProcessIdentifier."_submit"?>' id='<?=$this->table."_submit"?>' class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" data-records='<?="records_".$this->tableProcessIdentifier."_div"?>' data-tbl='<?=$this->tableProcessIdentifier?>' class='btn btn-primary add-update-agent' data-id='<?=$id?>' data-action='<?=$action?>'><?=$btntext?></button>
					<?php } else { ?>
                    <div class="col-md-12" align="right">
                    <button type="button" data-tbl='<?=$this->tableProcessIdentifier?>' class="btn btn-default btn-close-update" data-dismiss="modal">Close</button>
                    
                    <button type="submit" data-records='<?="records_".$this->tableProcessIdentifier."_div"?>' data-tbl='<?=$this->tableProcessIdentifier?>' class='btn btn-primary add-update-agent' data-id='<?=$id?>' data-action='<?=$action?>'><?=$btntext?></button>

                    
                    
                    
                    
					<?php } ?>
                    
                    
              	</div>
            </div>
          </div>
         </form>
        </div>
        <?php
		return true;
	}
	// Easy to remember form variations
	public function addForm()
	{
		$this->renderForm(false,false);	//for adding records
	}
	public function addModalForm()
	{
		$this->renderForm(true,false);	//for adding records
	}
	public function updateForm($id=0)
	{
		$this->renderForm(false,true,$id);	//for adding records
	}
	public function updateModalForm($id=0)
	{
		$this->renderForm(true,true,$id);	//for adding records
	}
	// Displays last message if form is being processed
	public function lastMsg($time=5000)
	{
		$request = "";
		if($this->method=="post")
		{
			$request = $_POST;
		}
		if($this->method=="get")
		{
			$request = $_GET;
		}
		if( isset($request[$this->tableProcessIdentifier]) || isset($request[$this->tableProcessIdentifier."_update"]))
		{
			$this_page = $_SERVER['PHP_SELF'];
			$this_page = str_replace("index.php","",$this_page)."?".$_SERVER['QUERY_STRING'];
			echo $this->lastMsg;
			if($time)
			$this->addJs("
			$('.alert').fadeTo($time, 500).slideUp(500, function(){
				$('.alert').slideUp(500);
				/*window.location='$this_page';*/
			});
			");
			return true;
		}
		else
			return false;

	}
	public static function showSingleLink($table,$title='',$class='')
	{
		$href = self::getTablePageHref($table);
		if($title=='')
			$title = ucwords(str_replace("_"," ",$table));
		echo "<a style='display:block; margin-bottom:15px' class='$class' href='$href'>".$title."</a>";
	}
	public static function showAllLinks($key_val=false)
	{
		$tables = self::allTables();
		for($i=0;$i<self::numTables();$i++)
		{
			if(self::isBaseTable($tables[$i]))
			{
				if(!isset($key_val[$tables[$i]]))
				{
					$title = ucwords(str_replace("_"," ",$tables[$i]));
				}
				else
				{	
				
					$title = ucwords(str_replace("_"," ",$key_val[$tables[$i]]));
					
				}
					self::showSingleLink($tables[$i],$title);
			}

		}

	}
	public static function pageMode()
	{
		if(isset($_GET[self::$crud360Get]) && in_array($_GET[self::$crud360Get],self::$crud360Keys))
			return true;
		else
			return false;
	}
	public static function encrypt ($value,$encryption='md5')
	{
		//var_dump($value,$encryption);

		$allwed = array("md5");
		if(in_array($encryption,$allwed))
		{
			switch($encryption)
			{
				
				case "md5" : { return md5($value);}
				default : { return md5($value);}				
			}
		}
	}
	//Add a record in a table
	public function updateRecord()
	{

		$request = "";
		if($this->method=="post")
		{
			$request = $_POST;
		}
		if($this->method=="get")
		{
			$request = $_GET;
		}
		//var_dump($request);
		$id_field = $this->primaryKey;
		//d460eed972c93ab0bc98e20301aee4ec
		
		if(isset($request[$this->tableProcessIdentifier."_update"]))
		{
			$idkey = $this->table."_id_hidden";
			$id = $request[$idkey];
			global $DB;
			$sql = "update `".$this->table."` set ";
			//$desi_sql = $sql;
			$values = array();
			foreach($request as $key=>$val)
			{
				//var_dump($key,$val);
				$place = $key;
				$key = explode("_clm_",$key);
				if(count($key)==2)
				{
					$key = $key[1];
					$key = str_replace("_update","",$key);
					$keyInfo  = $this->getFieldInfo($key);
					if($keyInfo['CRUD360_INPUT_EXT']=='password' && $val=='')
						continue;
					if($key!=NULL)
					{
						$sql.=" $key=:$place, ";
						//$desi_sql.=" `$key`='$val', ";
						$ctype= $keyInfo['Type'];
						if($ctype=='datetime' || $ctype=='timestamp')
						{
							$time = strtotime($val);
							$val = date("Y-m-d h:i:s",$time);
							//var_dump($request[$input_name]);
						}
						if($ctype=='date')
						{

							$time = strtotime($val);
							$val = date("Y-m-d",$time);
							//var_dump($request[$input_name]);
						}
						//var_dump($val);

						$values[$place] = $val;
					}
				}
			}
			$sql = substr($sql,0,strlen($sql)-2)." where $id_field='$id'";
			try{
				
				$stmt = $DB->PDO->prepare($sql);
				//var_dump($sql);
				//var_dump($values);
				$stmt->execute($values);
				$this->lastMsg = "<div class='alert alert-success'>Updated Successfully!</div>";
				return true;
			}
			catch (PDOException $e )
			{
				$this->lastMsg = "<div class='alert alert-danger'>Failed!".$e->getMessage()."</div>";
				///echo 'false';
				return false;
			}
			//echo 'true';
			return false;
		}
	}
	public function addRecord()
	{
	
		$request = "";
		if($this->method=="post")
		{
			$request = $_POST;
		}
		if($this->method=="get")
		{
			$request = $_GET;
		}
		
		//d460eed972c93ab0bc98e20301aee4ec
		
		if(isset($request[$this->tableProcessIdentifier]))
		{

			
			global $DB;
			$sql = "insert into $this->table(";
			for($i=0;$i<$this->nof;$i++)
			{
				if($this->fields[$i]['Type']!='timestamp' || $this->editTimestamp)
				{
					$name = $this->fields[$i]['Field'];
					$sql.= "`".$name."`,";
				}
			}
			$sql = substr($sql,0,strlen($sql)-1).") values (";
			$old_sql = $sql;
			for($i=0;$i<$this->nof;$i++)
			{
				if($this->fields[$i]['Type']!='timestamp' || $this->editTimestamp)
				{
					//var_dump($this->fields[$i]['Type']);
					$name = $this->fields[$i]['Field'];
					$sql.= ":".$name.",";
				}
			}
			$sql = substr($sql,0,strlen($sql)-1).")";
			$statment = $DB->PDO->prepare(($sql));

			$values = array();
			for($i=0;$i<$this->nof;$i++)
			{
				if($this->fields[$i]['Type']!='timestamp' || $this->editTimestamp)
				{
					$name = $this->fields[$i]['Field'];
					$key = $this->fields[$i]['Key'];
					$Extra = $this->fields[$i]['Extra'];
					$ctype = $this->fields[$i]['Type'];
					$input_name = "tbl_".$this->tableProcessIdentifier."_clm_".$name;
					


					if($this->fields[$i]['CRUD360_ENCRYPT']!='')
					{
						//var_dump($this->fields[$i]['CRUD360_ENCRYPT'],$request[$input_name]);

						$request[$input_name] = self::encrypt($request[$input_name],$this->fields[$i]['CRUD360_ENCRYPT']);
						//var_dump($request[$input_name]);
					}

					
					
					
					if(isset($request[$input_name]))
					{
						if($ctype=='datetime')
						{
							$time = strtotime($request[$input_name]);
							$request[$input_name] = date("Y-m-d h:i:s",$time);
							//var_dump($request[$input_name]);
						}
						if($ctype=='date')
						{

							$time = strtotime($request[$input_name]);
							$request[$input_name] = date("Y-m-d",$time);
							//var_dump($request[$input_name]);
						}
	
						if(is_array($request[$input_name]))
						{
							$request[$input_name] = $request[$input_name][count($request[$input_name])-1];
						}
						if($key=="PRI" && $Extra=="auto_increment")
						{
							$values[$this->fields[$i]['Field']] = NULL;
						}
						else
							$values[$this->fields[$i]['Field']] = $request[$input_name];
					}
					else
					{
						if($this->fields[$i]['Type']!='date' && $this->fields[$i]['Type']!='datetime' && $this->fields[$i]['Type']!='timestamp' && $this->fields[$i]['Key']!='PRI')
						{
							//var_dump($this->fields[$i]['Type']);
	
							$values[$this->fields[$i]['Field']] = $this->fields[$i]['CRUD360_DEFAULT'];
						}
						else
						{
							if($this->fields[$i]['Type']=='timestamp')
							{
								//$values[$this->fields[$i]['Field']] = "NULL";
							}
							else
							$values[$this->fields[$i]['Field']] = "0000-00-00";
						}
					}
				}
			}
			//var_dump($values);
			//======TESTING SQL 
			for($i=0;$i<$this->nof;$i++)
			{
				//var_dump($values[$this->fields[$i]['Field']]);
			}
			$old_sql = substr($old_sql,0,strlen($old_sql)-1).")";
			//var_dump($old_sql);

			//=======END TESTING SQL

			
			try {
				if($statment->execute($values))
				{	
				
					$this->lastMsg = "<div class='alert alert-success'>Successfully added record!</div>";
					$this->nor++;
					return true;
				//echo 'true';
				}
			}
			catch (PDOException $e )
			{
				//var_dump($e->errorInfo,$sql,$values);

				if(Config::$pdoVerbose)
					$this->lastMsg = "<div class='alert alert-danger'>Failed adding a record. ".$e->getMessage()."</div>";
				else
					$this->lastMsg = "<div class='alert alert-danger'>Failed adding a record. ".$e->errorInfo[2]."</div>";	
				
				return false;
			}
			//var_dump($values);
			
		//	$statment = $DB::PDO("insert into $this->table values (");
			
			
			//var_dump($request);
		}
		$this->lastMsg = "<div class='alert alert-danger'>Failed adding a record</div>";
		return false;

	}
	public function lookup($value,$column)
	{
		global $DB;
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$column)
			{
				$fieldInfo = $this->fields[$i];
				$table = $fieldInfo['CRUD360_LINKED_TABLE'];
				$id = $fieldInfo['CRUD360_LINKED_TABLE_ID'];				
				$title = $fieldInfo['CRUD360_LINKED_TABLE_TITLE'];								
				if($title!='')
				{
					$sql = "select $id,$title 'title' from $table where $id =:value";
					global $DB;
					//var_dump($sql);
					$stmt = $DB->PDO->prepare($sql);
					$stmt->execute(['value'=>"$value"]);
					$rows = $stmt->fetchAll();
					if(isset($rows[0]["title"]))
					{
						return "<span data-tooggle='tooltip' title='Linked record' style='color:#333'> <span style='color:#ccc
'>&#8627;</span> ".$rows[0]["title"]."</span>";
					}
					else
					{
						if($value==0)
							return "<i>Value not set</i>";
					return "<span data-tooggle='tooltip' title='Linked record with this field appears to have been removed' style='color:#c33; background:#ffefef; display:block; text-align:center'>".$value."</span>";
					}
				}
				else
					return $value;
				
			}
		}
		return $value;
?>
<?php
	}
	public function formatField($field,$type,$format='',$prepost='')
	{
		for($i=0;$i<$this->nof;$i++)
		{
			if($this->fields[$i]['Field']==$field)
			{
				$this->fields[$i]['CRUD360_FORMAT_PREPOST']=$prepost;
				$this->fields[$i]['CRUD360_FORMAT_TYPE']=$type;
				$this->fields[$i]['CRUD360_FORMAT']=$format;
				return;
			}
		}
	}
	public static function validhtmlColor ($color, $named=FALSE)
	{
	  /* Validates hex color, adding #-sign if not found. Checks for a Color Name first to prevent error if a name was entered (optional).
	  *   $color: the color hex value stirng to Validates
	  *   $named: (optional), set to 1 or TRUE to first test if a Named color was passed instead of a Hex value
	  */
	 
 
	  if ($named) {
	 
		$named = self::$htmlNamedColors;
		if (in_array(strtolower($color), $named)) {
		  /* A color name was entered instead of a Hex Value, so just exit function */
		  return $color;
		}
	  }
	  if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
		// Verified OK
	  }else if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
		$color = '#' . $color;
	  }
	  return $color;
	}
	
	public static function formatValue ($value,$type,$param='',$prepost='')
	{
		
		$acceptable_types = array("date","img","video","embedd","link","htmlColor");
		if(!in_array($type,$acceptable_types))
			return $value;
		
		$v_pre = '';
		$v_post = '';	
		if(is_array($prepost))
		{
			if(isset($prepost[0]))
				$v_pre = $prepost[0];
				
			if(isset($prepost[1]))
				$v_pre = $prepost[1];
		}
		switch ($type)
		{
			case "date":
			{
				$time = strtotime($value);
				return date($param,$time);
			}
			case "img":
			{
				
				$img = $v_pre.$value.$v_post;
			//	var_dump("img");
				$file = $img;
				$file_headers = @get_headers($file);
				if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
					$exists_online = false;
				}
				else {
					$exists_online = true;
				}
				if(file_exists($img) || $exists_online)
					return "<img $param class='crud360-records-img' src='$v_pre$value$v_post'>";
				else
					return $value;
			}
			case "video":
			{
				
					if(!empty($param))
					{

						$video = $v_pre.$value.$v_post;
						$type = $param;
						$file = $value;
						$file_headers = @get_headers($file);
						//var_dump($file_headers,$file);
						if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
							$exists_online = false;
						}
						else {
							$exists_online = true;
						}

						if(file_exists($video) || $exists_online)
						{
							$src = $v_pre.$value.$v_post;
							$other_src = $src;
							$other_type = $type;
							if($type=='ogg')
							{
								$other_src = str_replace(".ogg",'.mp4',$other_src);
								$other_type = "mp4";
							}
							if($type=='mp4')
							{
								$other_src = str_replace(".mp4",'.ogg',$other_src);
								$other_type = "ogg";								
							}
							
							if($type !='mp4' && $type !='ogg')
								return $value;
							
							return "
							<video preload='auto' controls class='crud360-records-video'>
							  <source src='$src' type='video/$type'>
							  <source src='$other_src' type='video/$other_type'>
							Your browser does not support the video tag.
							</video>
							";
						}
				   }
				   return $value;
				break;
			}
			case "link" :
			{
				if(!empty($param))
				{
					$attrib = $prepost;
					$href= $param;
						return "<a href='$href' $attrib>$value</a>";
				}
				else
					return $value;
				break;
			}

			case "htmlColor" :
			{
				if(!empty($value))
				{
					
					$valid = false;				
					if(strpos($value,"#")===0)
					{	
						$string = str_replace("#","",$value);
						$string = strtolower($string);
						if((strlen($string)==3 || strlen($string)==6))
						{
							  if (ctype_xdigit($string))
							  {
								  $valid = true;
							  }
						}
					}
					else
					{
						
						if(in_array($value,self::$htmlNamedColors))
								$valid = true;
						else
							$valid = false;
					}
					
					if(self::validhtmlColor($value) && $valid)
					{
						//var_dump($value);

						$text_color = self::readablecolor($value);
						return "<span style='display:block;padding-top: 2px; padding-bottom: 5px; background:$value; color:#$text_color; text-align:center; box-shadow:0 0 2px #ccc'>$value</span>";
					}
					else
						return "<span data-toggle='tooltip' title='Invalid HTML color specified'><i>".$value."</i></span>";
				}
				break;
			}
			case "prepost": {
				
				if(is_array($prepost))
				{
					if(isset($prepost[0]))
						$value = $prepost[0].$value;
					if(isset($prepost[1]))
						$value = $value.$prepost[1];
					return $value;
						
				}
				break;
				
			}
			default : 
			{
				return $value;
			}
		}
	}
	
	//******************** Utility function for formating fields
	
	public function formatDate($fieldName,$dateFormat)
	{
	}
	public function formatImage($fieldName,$htmlAttributes='',$pathPrefixPostfixArray='')
	{
	}
	public function formatVideo($fieldName,$videoType='mp4', $htmlAttributes='',$pathPrefixPostfixArray='')
	{
	}
	public function formatLink($fieldName,$href,$htmlAttributes='')
	{
	}

	
	//===========================================================
	
	
	//Shows all records 
	public static function defaultDivs()
	{
		echo "<div class='crud360-form-msg'></div>";
		echo "<div class='crud360-form-delete'></div>";

	}
	public function comboField($field)
	{
		if(is_array($field))
			$field = $field[0];
		
		$compare = array();
		for($i=0;$i<$this->nof;$i++)
		{
			$compare[] = $this->fields[$i]['Field'];
		}
		
		return !in_array($field,$compare);
		
	}
	public static function pre($var)
	{
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
	public function magic($ajax=false)
	{
	
		//var_dump($_GET);
		global $DB;

		//$max_records = $this->maxRecords;
		//var_dump($max_records);
		$sql_order = $this->sqlOrder;
		
		$where = $this->whereClause;
		$where_values = $this->whereClauseValues;	
		if(!is_array($where_values))
			$where_values=array();

		$sq  = "";
		$max_records = $this->maxRecords;
		//var_dump($_GET,$this->tableProcessIdentifier."_search_query");
		if(isset($_GET[ $this->tableProcessIdentifier . '_search_query']))
		{
			$sq = $_GET[$this->tableProcessIdentifier . '_search_query'];
		}
		
		if($where=='')
			$where = " WHERE 1 ";
		$gw = false;
		$sqa = explode(" ",$sq);
		if($sq!="")
		{
				$where.= " AND (";
				
				for($q=0;$q<count($sqa);$q++)
				{
					$sq = $sqa[$q];
					for($s=0;$s<count($this->fields);$s++)
					{
							$id1= "_".$q."_L".$s;
							$id2 = "_".$q."_SL".$s;
					$where.= "  ( `".$this->fields[$s]['Field']."` like :SQ$id1 OR `".$this->fields[$s]['Field']."` sounds like :SQ$id2 ) OR";
							$where_values["SQ$id1"]="%".$sq."%";
							$where_values["SQ$id2"]="%".$sq."%";
							$gw = true;
							//var_dump($s,$where_values["SQ$s"],$where_values["SQ$s$s"]);
					}
				}
				
				$where.=" ) ";				
		}
		
		if($gw)
			$where = substr($where,0,strlen($where)-5).")";
		$sql = "select * from $this->table $where";
		//self::pre($sql);
		//self::pre($where_values);

		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute($where_values);
		$rows = $stmt->fetchAll();
		$nor = count($rows);
		
		
		//self::pre($nor);
		
			
		
		$page_breaks = (float)$nor/(float)$max_records;
		$page_breaks = ceil($page_breaks);
		
		//via ajax
		if($ajax==true)
			$limit = $_GET['id']-1;
		else
			$limit = 0;
		
		
		$page_links='';

		if($page_breaks>20)
		{
			for($i=0;$i<$page_breaks;$i++)
			{
				if($limit==$i)
					$fade = 'fade-record-link';
				else
				{
					$fade='';
				}
				$data_qs = $_SERVER['QUERY_STRING'];
				$data_tbl = $this->tableProcessIdentifier;
				$data_limit = $i+1;
				$page_links .= "<span class='btn btn-link pagination-trigger $fade' data-id='records_".$this->tableProcessIdentifier."_div' data-qs='$data_qs' data-tbl='$data_tbl' data-limit='$data_limit'>".($i+1)."</span>";
			}
		}
		else
		{
			for($i=0;$i<$page_breaks;$i++)
			{
				if($limit==$i)
					$fade = 'fade-record-link';
				else
				{
					$fade='';
				}
				$data_qs = $_SERVER['QUERY_STRING'];
				$data_tbl = $this->tableProcessIdentifier;
				$data_limit = $i+1;
				$page_links .= "<span class='btn btn-link pagination-trigger $fade' data-id='records_".$this->tableProcessIdentifier."_div' data-qs='$data_qs' data-tbl='$data_tbl' data-limit='$data_limit'>".($i+1)."</span>";
			}
		}
		$paginator_page = $limit+1;		
		//if(empty($where) && empty($where_values))
		//	exit();
		$enctable = $this->tableProcessIdentifier;
		$allow=$this->columns;
		if($ajax==false)
		{
			$this->addModalForm();
			$this->lastMsg(); // in case processing a form, show last message 
			
			echo "<div class='crud360-form' id='crud360-form-$enctable'></div>";
			//echo "<div class='crud360-form-delete' id='crud360-form-delete-$enctable'></div>";
			$show_title = $this->recordHeading;
			if($show_title) echo "<h3>".ucwords($this->table)."</h3>";
			echo "<div class='crud360-records-holder' id='records_".$this->tableProcessIdentifier."_div'>";
		}
		
		if($nor==0)
		{
			$this->lastMsg = "<p align='center' style='padding:15px;'>There are no records!</p>
			
			";
			
			
			echo $this->lastMsg;
			if($ajax==false)
				echo "<div class='clearfix'></div></div>";

			return false;
		}

		$current_fields = array();
		$f=0;
		if(empty($allow))
		{
			for($i=0;$i<$this->nof;$i++)
			{
				$allow[$i]=$this->fields[$i]['Field'];
			}
		}
		
		
		$pk = $this->primaryKey;
		$pk_added = false;
		if(!in_array($pk,$allow))
		{
			//var_dump($pk);
			$allow[]=$pk;
			$pk_added =true;
		}
		
		
		$available  = count($allow);
		if($pk_added)
		{
			$available--;
		}

		
		//var_dump($allow,count($allow));
		$select_fields ="";
		
		for($i=0;$i<count($allow);$i++)
		{
			$current_field = $allow[$i];
			//var_dump($i,$current_field);
			if(is_array($current_field))
				$select_fields.="`".$current_field[0]."`, ";
			else
				$select_fields.="`".$current_field."`, ";
		}
		$select_fields = substr($select_fields,0,strlen($select_fields)-2);	
		
		
		
		

		$start_rec = $limit*$max_records;
		//var_dump($start_rec);
		
		$sql = "select $select_fields from $this->table $where order by `$pk` $sql_order LIMIT $start_rec,$max_records";
		//var_dump($sql);
		$stmt = $DB->PDO->prepare($sql);
		$stmt->execute($where_values);
		$rows = $stmt->fetchAll();
		
		
		$page_records_info = "Currently showing ".count($rows)." out of ".$this->nor." record(s) on Page $paginator_page.";
		//var_dump($rows); return;
		
		if($this->recordSerial)
			$rh = "<th>Sr #</th>";
		else
			$rh = "";
		$modal = $this->modalForm;
		if(!$modal)
			$modal = 'nomadal';
		else
			$modal = 'modal';
		$html_id = $this->tableProcessIdentifier."_table_modal_update";

		$html_id = "";

		

		if($this->recordTpl=='' )	
		{
			echo "<table class='table'><tr>$rh";
			$fno = 1;
			for($i=0;$i<count($allow);$i++)
			{
				if($allow[$i]==$this->xsField)
					$fno = $i;
			}
			
			for($i=0;$i<count($allow);$i++)
			{
			
				
				if($allow[$i] == $this->primaryKey && $allow[count($allow)-1] == $this->primaryKey && $pk_added==true)
					continue;
				
				//var_dump($this->comboField($allow[$i]),$allow[$i]);
				$attr = $this->getFieldInfo($allow[$i]);
				
				//var_dump($attr);
				$head = $attr['CRUD360_TITLE'];
				$xsField  = $this->xsField;
				
				
				
				if($i==$fno)
				{
					if($allow[$i]!=$this->primaryKey)
						$hideclass='';
				    else
					$hideclass="class='hide-768'";	
				}
				else
					$hideclass="class='hide-768'";	
					
				if($available==$fno)
				$hideclass="";	
	
				
				
	
				//var_dump($allow[$i]."|| ".$allow[$i][0]." = ".$head);
				//var_dump($allow[$i],$attr['CRUD360_SUPRESS']);
				if(in_array($attr['Field'],$allow) && !$attr['CRUD360_SUPRESS'] || $this->comboField($allow[$i]))
				{
						$header = $head;
	
						//var_dump($this->comboField($allow[$i]) , $this->comboField($allow[$i][0]) , $head);
						if($this->comboField($allow[$i]))
						{
							if(is_array($allow[$i]))
							{
								$header =  $allow[$i][1];
								$current_fields[$f] = $allow[$i][0];	
							}
							else
							{
								$header =  $allow[$i];
								$current_fields[$f] = $allow[$i];	
							}
						}
						else
							$current_fields[$f] = $attr['Field'];
	
	
						if($attr['CRUD360_COLUMN_WIDTH']!=false)
							$cw = " width = '".$attr['CRUD360_COLUMN_WIDTH']."' ";
						else
							$cw = "";
	
						
						
						//var_dump($header);
						echo "<th $cw $hideclass>$header</th>";
						$f++;
						
				}
				/*else
				{
					$current_fields[$f] = $allow[$i];
				}*/
				//var_dump($rows);
			}
			if(self::$opWidth!="")
				$opw = "width:".self::$opWidth;
			else
				$opw = "";
			//var_dump($current_fields);
			echo "<th style='text-align:right; $opw' class='operations'>Operations</th></tr>";
			for($k =0;$k<count($rows);$k++)
			{
				$row = $rows[$k];
				//var_dump($row);
				$pk = $this->primaryKey;
				//$jrow = json_encode($row);
				//$jrow = urlencode(serialize($row));
				if($this->recordSerial)
				{
	
					$rs = $k+ 1 + $limit*$max_records;
					
					$rs = "<td><span>$rs</span></td>";
				}
				else
					$rs = "";
				$row_html_id = "row_".$this->tableProcessIdentifier."_".$k;
				echo "<tr id='$row_html_id'>$rs";
				for($i=0;$i<count($current_fields);$i++)
				{
					if($i==1)
						$hideclass='';
					else
							$hideclass="class='hide-768'";	
	
					if($available==1)
					$hideclass="";	
	
					
					$fvalue = $row[$current_fields[$i]];
					
					$clip_amount=false;
					if($this->clipAllLongText)
						$clip_amount = $this->clipAllLongText;
						
					$fi = $this->getFieldInfo($current_fields[$i]);
	
					if($fi['CRUD360_CLIP_TEXT'])
						$clip_amount = $fi['CRUD360_CLIP_TEXT'];
	
	
						
					
					//var_dump($clip_amount);
					if($clip_amount && strlen($fvalue)>$clip_amount)
						$fvalue = substr($fvalue,0,$clip_amount)."...";
					
					$fvalue = $this->lookup($fvalue,$current_fields[$i]);
	
					if($fi['CRUD360_INPUT_EXT']=='password' && $this->maskPasswords==true)
						$fvalue = "<span style='font-size:10px'>&#9899;&#9899;&#9899;&#9899;&#9899;&#9899;</span>";
					
					
					if($fi['CRUD360_FORMAT_TYPE']!='')
					{
						//var_dump($fi);
	
						$format_type = $fi['CRUD360_FORMAT_TYPE'];
						$format_pattern = $fi['CRUD360_FORMAT'];
						$format_prepost = $fi['CRUD360_FORMAT_PREPOST'];
						$format_pattern = str_replace("CRUD360_CURRENT_ROW_ID",$row[$pk],$format_pattern);
						$fvalue = self::formatValue($fvalue,$format_type,$format_pattern,$format_prepost);
					}
	
					//$fvalue= htmlspecialchars($fvalue);

					if($fvalue=='')
						$fvalue =  "<i>Value not set</i>";
					//if($current_fields[$i]==$this->signatureField)
					//{
					//	echo "<td $hideclass><button data-toggle='modal' data-target='#$html_id'  data-pk='$pk' data-id='".$row[$pk]."' class='btn btn-link pure-link btn_$html_id'>$fvalue</button></td>";
					//}
					//else
					//{
						echo "<td $hideclass>$fvalue</td>";
					//}
				}
					
				$serial = $k+1;
				echo "<td class='operations' align='right'>
				<button data-toggle='$modal' data-target='#$html_id' data-records='records_".$this->tableProcessIdentifier."_div' data-tbl-title='".$this->tableTitle."' data-serial='$serial' data-tbl='".$this->tableProcessIdentifier."' data-qs='".$_SERVER['QUERY_STRING']."'  data-pk='$pk' data-id='".$row[$pk]."' class='btn btn-info  btn_$html_id'>View/Edit</button>";
				
				if(self::$noDeleteButton!=true)
				{
					echo "<button data-toggle='$modal' data-target='#$html_id' data-records='records_".$this->tableProcessIdentifier."_div' data-serial='$serial' data-tbl='".$this->tableProcessIdentifier."' data-pk='$pk'  data-qs='".$_SERVER['QUERY_STRING']."' data-id='".$row[$pk]."' class='btn btn-warning  btn_$html_id' data-tbl-title='".$this->tableTitle."' data-rowid='$row_html_id'>Delete</button>
				</td></tr>";}
				
			}
			echo "
			</table>
			";
		}
		else
		{
			if(file_exists("crud360/tpl/records/".$this->recordTpl.".php"))
			{
				
				
				
				for($i=0;$i<count($rows);$i++)
				{
					
					ob_start();
					echo "<div class='operations records-tpl'>";
					include("crud360/tpl/records/".$this->recordTpl.".php");
					$html = ob_get_clean();

					$serial = $i+1;
					
					
					$row = $rows[$i];
					$row_html_id = "row_".$this->tableProcessIdentifier."_".$i;
					$ops_html = "<button data-toggle='$modal' data-target='#$html_id' data-records='records_".$this->tableProcessIdentifier."_div' data-tbl-title='".$this->tableTitle."' data-serial='$serial' data-tbl='".$this->tableProcessIdentifier."' data-qs='".$_SERVER['QUERY_STRING']."'  data-pk='$pk' data-id='".$row[$this->primaryKey]."' class='btn btn-info  btn_$html_id'>View/Edit</button>
				<button data-toggle='$modal' data-target='#$html_id' data-records='records_".$this->tableProcessIdentifier."_div' data-serial='$serial' data-tbl='".$this->tableProcessIdentifier."' data-pk='$pk'  data-qs='".$_SERVER['QUERY_STRING']."' data-id='".$row[$pk]."' class='btn btn-warning  btn_$html_id' data-tbl-title='".$this->tableTitle."' data-rowid='$row_html_id'>Delete</button>";
					foreach($row as $key=>$val)
					{
						
						$fi = self::getFieldInfo($key);
						$fvalue=$val;
	
						$clip_amount=false;
						if($this->clipAllLongText)
							$clip_amount = $this->clipAllLongText;
							
						if($fi['CRUD360_CLIP_TEXT'])
							$clip_amount = $fi['CRUD360_CLIP_TEXT'];
						//var_dump($clip_amount);
						if($clip_amount && strlen($fvalue)>$clip_amount)
							$fvalue = substr($fvalue,0,$clip_amount)."...";
						
						$fvalue = $this->lookup($fvalue,$key);
		
						if($fi['CRUD360_INPUT_EXT']=='password' && $this->maskPasswords==true)
							$fvalue = "<span style='font-size:10px'>&#9899;&#9899;&#9899;&#9899;&#9899;&#9899;</span>";
						
						
						if($fi['CRUD360_FORMAT_TYPE']!='')
						{
							//var_dump($fi);
		
							$format_type = $fi['CRUD360_FORMAT_TYPE'];
							$format_pattern = $fi['CRUD360_FORMAT'];
							$format_prepost = $fi['CRUD360_FORMAT_PREPOST'];
							//var_dump($format_prepost,$format_type);
							$fvalue = self::formatValue($fvalue,$format_type,$format_pattern,$format_prepost);
						}
		
						if($fvalue=='')
							$fvalue =  "<i>Value not set</i>";
	

						
						
						$field_find = "{($key)}";
						if($this->recordKeys)
							$html = str_replace($field_find,"<span class='tpl-key'>$key</span>: $fvalue",$html);
						else
							$html = str_replace($field_find,$fvalue,$html);						
					}
					
					if(strpos($html,"{((operations))}")===false)
					{
						$html.="<div class='col-md-12'>{((operations))}</div>";
					}
					
					$html = str_replace("{((operations))}",$ops_html,$html);
				echo $html."</div><div class='clearfix'></div>" ;

				}
				
				
			}
			else
			{
				echo "Fatal Error: tpl file '".$this->recordTpl."' missing!";
				return;
			}
		}
		
		if($this->paginationLinks) echo "<div class='paginator'>$page_links</div>
			<div class='record-info'>$page_records_info</div>";
		if($ajax==false)
			echo "
			</div>";
	}
		
	public static function javascript($objects)
	{
		//var_dump($obejcts);
		echo "<script>";
		for($i=0;$i<count($objects);$i++)
		{
				$objects[$i]->loadJs();
		}
		echo "</script>";
	}
	
	//pass crud360 objects to this function
	public static function process($objects)
	{
		for($i=0;$i<count($objects);$i++)
		{

				$objects[$i]->addRecord();
				$objects[$i]->updateRecord();
		}
		
		if(isset($_GET['id']) && isset($_GET['identifier']))
		{
			for($i=0;$i<count($objects);$i++)
			{
				$identifier = $_GET['identifier'];
				//var_dump($_SERVER['QUERY_STRING']);
				if($objects[$i]->getIdentifier() == $identifier)
				{
					//var_dump($identifier);
					$objects[$i]->returnAjaxResponse();
					//exit();
				}
			}
			
		}
	}
	
	public function returnAjaxResponse()
	{
		if(isset($_GET['ajax']) && $_GET['ajax']=='true')
		{

			if(isset($_GET['action']))
			{
				$action = $_GET['action'];
				if(method_exists($this,$action))
				{
					if(isset($_GET['id']) && isset($_GET['identifier']) && $_GET['identifier'] == $this->tableProcessIdentifier)
					{	
						
						$id = $_GET['id'];
						$this->$action($id);
					//call_user_func(array($this,$action));
					}
					exit();
				}
			}
		exit();
		}
	}
}
Crud360::storeTableHashes();
?>
