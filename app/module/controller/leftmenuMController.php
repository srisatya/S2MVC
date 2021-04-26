<?php
//testModule
class leftmenuMController extends Module
{
	
	public function index($params=[])
	{
		
		$lang='en';
		$usertipe=1;
		if(is_array($params))
		{
			if(isset($params['lang']))
			{
				$lang=$params['lang'];
			}
			if(isset($params['usertipe']))
			{
				$usertipe=$params['usertipe'];
			}
		}
		
		
		
			
		
		$this->model('leftmenu');
		$this->view('leftmenu/index',[]);
		
		$classname =str_replace("MController","",__CLASS__);
		$arrbas = $this->getModuleLang($classname,$lang);
		$this->model->getAllModule('en',0,0,$usertipe,'menu');
		$this->view->leftmenu = $this->model->deretmenu;
		 //echo $classname;
		 //var_dump($this->model->getAllModule());
		 
		$this->view->render();//render terakhir
		
	}
	
	
	
	
}

?>