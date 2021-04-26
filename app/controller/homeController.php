<?php

class homeController extends Controller
{
	public $userinfo;
	public function __construct()
	{
		
	}
	
	public function index($id='',$name='')
	{
		//echo "aku di dalam  class " . __CLASS__ . ' method ' . __METHOD__;
		//echo 'id is '. $id .' name :'. $name;
		//if(isset())
		
		//$this->model('demo');					
		$this->view('home'. DIRECTORY_SEPARATOR .'index',['name' => $name,'id' => $id,'userinfo'=>$this->userinfo]);
		
		//$this->view->lang = $this->model->langs();
		$this->view->judul="Halaman Demo";
		$this->view->css=[];
		$this->view->js=[];
		 
		$data=[];
		if($id == "lang")
		{
			if(!empty($name))
			{
				$data =['lang'=>$name];				
			}else
			{
				$data =['lang'=>'en'];	
			}	
		}
		if(count($data) == 0)
          	$data =['lang'=>'en'];	
		
		$this->view->lang = $this->bahasa($data);
		$this->view->lang_name = $data['lang'];	//sisipkan tuk module	
		$this->view->paraminfo = $this->userinfo;		
		$this->view->render();
		
		
		
	}
	
	
	
}