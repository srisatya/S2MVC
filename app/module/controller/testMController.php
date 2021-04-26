<?php
//testModule
class testMController extends Module
{
	
	public function index($params=[])
	{
		
		$lang='en';
		if(is_array($params))
		{
			if(isset($params['lang']))
			{
				$lang=$params['lang'];
			}
		}
		
			
		
		$this->model('test');
		$this->view('test/test',[]);
		
		$classname =str_replace("MController","",__CLASS__);
		$arrbas = $this->getModuleLang($classname,$lang);
        $this->view->bas = $this->model->getBahasa(); 		
		$this->view->lang = $arrbas;
		$this->view->render();//reder terakhir
		
	}
	
	
	public function pagination($params=[])
	{
		$lang='en';
		if(is_array($params))
		{
			if(isset($params['lang']))
			{
				$lang=$params['lang'];
			}
		}
		
			
		
		$this->model('test');
		$this->view('test/pagination',[]);
		
		$classname =str_replace("MController","",__CLASS__);
		$arrbas = $this->getModuleLang($classname,$lang);
        $this->view->bas = $this->model->getBahasa(); 		
		$this->view->lang = $arrbas;
		$this->view->render();//reder terakhir
	}
	
}

?>