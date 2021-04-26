<?php
class View
{
	protected $view_file;
	protected $view_data;
	//protected $lang;
	
	public function __construct($view_file,$view_data)
	{
		$this->view_file = $view_file;
		$this->view_data = $view_data;
		
	}
	
	public function render()
	{
		if(file_exists(VIEW . $this->view_file . '.mview'))
		{
			include VIEW . $this->view_file . '.mview';
		}
	}
	
	public function getAction()
	{
		//return (explode('\\',$this->view_file)[1]);
		return ($this->view_file);
	}
	
	public function getBaseConfig($kolom='')
	{
	  $rsl=false;
	  if(file_exists(DATA . 'config.inc'))
		{
			$file = fopen(DATA . 'config.inc',"r");
			$config = json_decode(fread($file,filesize(DATA . 'config.inc')),true);			
			fclose($file);
			$rsl=$config;		
		}
	
		if(isset($kolom) && !empty($kolom))	
		  return $rsl[0][$kolom];
	    else
		  return 'default';	
	  
	}
	
	public function getTheme($sesi='')
	{
		if(!empty($sesi))
		{
			if(!empty($this->getBaseConfig('THEME')))
				if(file_exists(THEME. $this->getBaseConfig('THEME') . DIRECTORY_SEPARATOR .$sesi .'.mview'))
					include THEME. $this->getBaseConfig('THEME') . DIRECTORY_SEPARATOR .$sesi .'.mview';	
				else
					echo '';
			else
				if(file_exists(THEME. 'default' . DIRECTORY_SEPARATOR .$sesi .'.mview'))
					include THEME. 'default' . DIRECTORY_SEPARATOR .$sesi .'.mview';
				else
					echo '';
			
			/*
			if(!empty($this->getBaseConfig('THEME')))
				if(file_exists(THEME. DIRECTORY_SEPARATOR . $this->getBaseConfig('THEME') . DIRECTORY_SEPARATOR .$sesi .'.mview'))
					return THEME. DIRECTORY_SEPARATOR . $this->getBaseConfig('THEME') . DIRECTORY_SEPARATOR .$sesi .'.mview';
			else
				if(file_exists(THEME. DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR .$sesi .'.mview')
					return THEME. DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR .$sesi .'.mview';
				
				*/
			
		}
		
		
	}
	
	/*
	public function getModule($name='',$method='',$view='',$params=[])
	{
		$result='';
		$this->module_name = $name;		
		$mview = $this->mView($view);
		$result = $this->renderModule($mview,$method,$params);
		print $result;
	}*/
	
   public function getModule($module_name='',$action='',$params='')
   {
	  
	   $module_name = $module_name."MController";//mencari controller module
	   if(file_exists(MODULEC . $module_name . '.php'))
	   {
		   $module_name = new $module_name;
		   $params=['params'=>$params];
		   if(empty($action))
			   $action = $this->action;
		   
			if(method_exists($module_name,$action))
			{
			    call_user_func_array([$module_name,$action],$params);
			}
			//$html='ada module';
	   }
	   
	   
   }
	
}