<?php
class Module
{
   protected $module_name='';
   protected $module_params=[];
   protected $action = 'index';
   protected $view;
   protected $data;
   protected $model;
   
   public function view($viewName,$data=[])
	{
		//$this->view = array('view_file'=>$viewName,'view_data'=>$data);
		$this->view = new MView($viewName,$data);		
		return $this->view;
		
	}
   
   public function model($modelName)
	{
		if(file_exists(MODULEM . $modelName . '.php'))
		{
			require MODULEM . $modelName . '.php';
			$this->model = new $modelName;
			
		}
	}
	
   public function getModuleLang($classname='',$lang='en')
   {
	  $arrbas=[];
	  $path=MODULE . 'lang'. DIRECTORY_SEPARATOR . $classname . DIRECTORY_SEPARATOR . $lang .'.inc';
	  if(file_exists($path))
					{
					
						
						$file = fopen($path,"r");
						$jbas = json_decode(fread($file,filesize($path)),true);			
						fclose($file);
					
						foreach($jbas[0] as $key=>$bas)
						{
							$arrbas[$key]=$bas;
						}
							
					}
					
					
	return $arrbas;				
		
   }
   
   
   /*
   protected function renderModule($view='',$action='',$params='')
   {
	   $html="No Module";
	   $this->module_name = $this->module_name."MController";
	   if(file_exists(MODULEC . $this->module_name . '.php'))
	   {
		   $this->module_name = new $this->module_name;
		   $this->module_params=['view'=>$view,'params'=>$params];
		   if(empty($action))
			   $action = $this->action;
		   
			if(method_exists($this->module_name,$action))
			{
			    $html=call_user_func_array([$this->module_name,$action],$this->module_params);
			}
			//$html='ada module';
	   }
	   
	   return $html;
   }
   
   
   protected function mView($viewname='')
   {
	   $rsl='no';
	   $path = MODULE .'view'. DIRECTORY_SEPARATOR .$this->module_name . DIRECTORY_SEPARATOR . $viewname . '.mview';
	    if(file_exists($path))
	    {
			$file = fopen($path,'r');
			$rsl=fread($file,filesize($path));						
			fclose($file);				
	    }	
		//$rsl=$path;
       return $rsl;		
   }
   
  */
   
   
   
}

?>