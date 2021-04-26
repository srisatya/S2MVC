<?php
class MView
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
		if(file_exists(MODULEV . $this->view_file . '.mview'))
		{
			include MODULEV . $this->view_file . '.mview';
		}else
		{
			 echo "no module";
		}	
	}
	
	
}