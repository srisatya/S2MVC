<?php
class Model
{
	
	protected $config=[];
	protected $lang=[];
	
	protected $host;
	protected $dbname;
	protected $dbuser;
	protected $dbpass;
	
	protected $conn;
    protected $DB;
  
  
  private function load()
  {
	  $rsl=false;
	  if(file_exists(DATA . 'config.inc'))
		{
			$file = fopen(DATA . 'config.inc',"r");
			$this->config = json_decode(fread($file,filesize(DATA . 'config.inc')),true);			
			fclose($file);
			$rsl=$this->config;		
		}
		return $rsl;
  }
  
  protected function connect()
  {
	  if($rsl=$this->load())
	  {
		  $dbinfo = $rsl[0];
		  if(isset($dbinfo['HOST']) && !empty($dbinfo['HOST']))
		  {
			  if(isset($dbinfo['DBNAME']) && !empty($dbinfo['DBNAME']))
				  {
					  if(isset($dbinfo['DBUSER']) && !empty($dbinfo['DBUSER']))
					  {
						  if(isset($dbinfo['DBPASS']) && !empty($dbinfo['DBPASS']))
						  {
							$connection = mysqli_connect($dbinfo['HOST'],$dbinfo['DBUSER'],$dbinfo['DBPASS'],$dbinfo['DBNAME']);
							return $connection;
						  }else
						  {
							  return false;
						  }
					  }else
					  {
						  return false;
					  }
				  }else
				  {
					  return false;
				  }
		  }else
		  {
			  return false;
		  }
	
	  }else
	  {
		 return false; 
	  }		  
  }
  
 protected function connect2()
  {
	$arr=false;
	require VENDOR . 'autoload.php';  
	  
	 if($rsl=$this->load())
	  {
		  $dbinfo = $rsl[0];
          $connection = new PDO('mysql:host='.$dbinfo['HOST'].';dbname='.$dbinfo['DBNAME'], $dbinfo['DBUSER'], $dbinfo['DBPASS']);
		  
		  $DB = new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) use($connection)
				{
					$statement = $connection->prepare($queryString);
					$statement->execute($queryParameters);

					// when the query is fetchable return all results and let hydrahon do the rest
					if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface)
					{
						return $statement->fetchAll(\PDO::FETCH_ASSOC);
					}
				});
				
		$arr = ['conn'=>$connection,'DB'=>$DB];		
	  }	
   return $arr;	  
  }
  
  protected function connect3()
  {
	$rsl=false;
	//require VENDOR ."s2db" . DIRECTORY_SEPARATOR . "DB.php";
	require VENDOR . 'autoload.php';
	if($rsl=$this->load())
	  {
		  $dbinfo = $rsl[0];
		  if(isset($dbinfo['HOST']) && !empty($dbinfo['HOST']))
		  {
			  if(isset($dbinfo['DBNAME']) && !empty($dbinfo['DBNAME']))
				  {
					  if(isset($dbinfo['DBUSER']) && !empty($dbinfo['DBUSER']))
					  {
						  if(isset($dbinfo['DBPASS']) && !empty($dbinfo['DBPASS']))
						  {
	
								if($connect = new DB($dbinfo['HOST'],$dbinfo['DBUSER'],$dbinfo['DBPASS'],$dbinfo['DBNAME']))
								{
									$rsl= $connect;//instan DB
								}else
								{
									$rsl= false;
								}
								
						  }
					}
			     }
		}
		
	}
	return $rsl;						
  }
  
  
  public function getLang($data=[])
  {
	  $hsl=false;
	  if(isset($data['lang']) && !empty($data['lang']))
	  {
		$lang=$data['lang'];  
		if(file_exists(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc'))
					{
						$_SESSION['lang']=$lang;
						$file = fopen(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc',"r");
						$this->lang = json_decode(fread($file,filesize(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc')),true);			
						fclose($file);
						$hsl=$this->lang;		
					}
		
		
		
	  }else if(isset($_SESSION['lang']))
	  {
		  
		  $lang=$_COOKIE['lang'];  
		  if(file_exists(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc'))
					{
						//setcookie("lang", $lang);
						$file = fopen(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc',"r");
						$this->lang = json_decode(fread($file,filesize(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc')),true);			
						fclose($file);
						$hsl=$this->lang;		
					}
		  
	  }	  
	  else
	  {  
		  
		  $lang='en';
		 
		  if($rsl=$this->load())
		  {
			 $dbinfo = $rsl[0];
			   if(isset($dbinfo['LANG']) && !empty($dbinfo['LANG']) )
			   {
				$lang =  $dbinfo['LANG'];
			   }
				  $hsl=false;
				  if(file_exists(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc'))
					{
						$_SESSION['lang']=$lang;
						$file = fopen(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc',"r");
						$this->lang = json_decode(fread($file,filesize(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc')),true);			
						fclose($file);
						$hsl=$this->lang;		
					}
					
					   
		  }
	  }
	  
	  return $hsl; 
	  
  }
  
  
  public function setCurrentPage()
  {
	  $rsl=[];
	  $request = trim($_SERVER['REQUEST_URI'],'/');
		if(!empty($request))
		{
			$url = explode('/',$request);
			$controller = isset($url[0]) ? $url[0] . 'Controller' : 'homeController';
			$action = isset($url[1]) ? $url[1] : 'index';
			unset($url[0],$url[1]);
			$prams = !empty($url) ? array_values($url) : [] ;
			$rsl =['controller'=>$controller,'action'=>$action,'args'=>$prams];
		
		}
		
		
		return $rsl;
  }
  
  public function setReplace($line,$data=[])
  {
	if(count($data) > 0)
	{		
			 if (preg_match_all("/\{\{[a-z_A-Z0-9_]{1,1000}\}\}/i", $line, $match))
				 {	   
					  if($match[0] && count($match[0]) > 0)
						  foreach($match[0] as $mc)
						  {
							 foreach($data as $key=>$dat) 
							 {
								 $ganti="{{".$key."}}";
								 if($mc == $ganti)
								 {
									 $line = str_replace($mc,$dat,$line); 
								 }
							 }
						  }
				}
		
	}	
		return $line;
  }
  //getHakByName('module','nama','id','admin_hak','tipe_admin_id','module',$tipe,$modulename,$akses)
  protected function getHakByName($tbmodule,$keymodulename,$keymoduleid,$tbhak,$keyid,$keycol,$tipe,$modulename,$akses)
   {
	 $DB1=$this->connect3()->table($tbmodule);
	  $arr1 =$DB1->select()
	             ->where($keymodulename,'=',$modulename)
				 ->get();
	  if(count($arr1) > 0)
	  {		  
			  $moduleid = $arr1[0][$keymoduleid];
			  $DB=$this->connect3()->table($tbhak);
			   $arr=$DB->select()
					 ->where($keyid,'=',$tipe)
					 ->andWhere($keycol,'=',$moduleid)
					 ->get();
					if(count($arr) > 0)
					{
						if((int)$arr[0][$akses] == 1)
							return true;
						else
							return false;			
						
					}else
					{
						return false;
					}
	
	  }else
	  {
		  return false;
	  }	
    		
   }
   
  // getHakById('admin_hak','tipe_admin_id','module',$tipe,$moduleid,$akses)
  public function getHakById($tbhak,$keyid,$keycol,$tipe,$moduleid,$akses)
  {
	 $DB=$this->connect3()->table($tbhak);
     $arr=$DB->select($akses)
	         ->where($keyid,'=',$tipe)
			 ->andWhere($keycol,'=',$moduleid)
			 ->get();
	var_dump($arr);
	/*if(count($arr) > 0)
	{
		if((int)$arr[0][$akses] == 1)
		    return true;
        else
            return false;			
		
	}else
	{
		return false;
	}	
	*/
    		
  }
  
  
}

?>