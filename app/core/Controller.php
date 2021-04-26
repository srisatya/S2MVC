<?php
class Controller
{
	protected $view;
	protected $model;
	protected $langs;
	
	public function view($viewName,$data=[])
	{
		//$this->view = array('view_file'=>$viewName,'view_data'=>$data);
		$this->view = new View($viewName,$data);		
		return $this->view;
		
	}
	
	public function model($modelName)
	{
		if(file_exists(MODEL . $modelName . '.php'))
		{
			require MODEL . $modelName . '.php';
			$this->model = new $modelName;
			
		}
	}
	
	public function bahasa($data=[])
	{
	  $hsl=false;
	  if(isset($data['lang']) && !empty($data['lang']))
	  {
		$lang=$data['lang'];  
		if(file_exists(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc'))
					{
						$_SESSION['lang']=$lang;
						$file = fopen(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc',"r");
						$this->langs = json_decode(fread($file,filesize(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc')),true);			
						fclose($file);
						$hsl=$this->langs;		
					}
		
		
		
	  }else if(isset($_SESSION['lang']))
	  {
		  
		  $lang=$_SESSION['lang'];  
		  if(file_exists(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc'))
					{
						//setcookie("lang", $lang);
						$file = fopen(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc',"r");
						$this->langs = json_decode(fread($file,filesize(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc')),true);			
						fclose($file);
						$hsl=$this->langs;		
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
						$this->langs = json_decode(fread($file,filesize(DATA . 'lang'. DIRECTORY_SEPARATOR .$lang.'.inc')),true);			
						fclose($file);
						$hsl=$this->langs;		
					}
					
					   
		  }
	  }
	  
	  return $hsl; 
	}
	
	
	public function authorize()
	{
		$sessionid="";
		if(isset($_SESSION['register_at']))
		{
			$sessionid = $_SESSION['register_at'];
			if(!isset($_SESSION[$sessionid]))
			{
				return false;
			}else
			{
				if(count($_SESSION[$sessionid]) > 0)
					return $_SESSION[$sessionid];
				else 
					return false;
			}
		}else
		{
			return false;
		}
	}
	
	
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
	
	
}
