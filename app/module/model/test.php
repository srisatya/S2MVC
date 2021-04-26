<?php

class test extends Model
{
	protected $conn2;
	protected $DB;
   public function __construct()
	{
		
		$this->conn = $this->connect();		
		$dbql=[];
		if($dbql=$this->connect2())
		{
			$this->conn2 = $dbql['conn'];
			$this->DB = $dbql['DB'];
		}
  }
   
   
   public function getBahasa()
   {
	   $rsl=[];
	   if($hsl = mysqli_query($this->conn,"SELECT * FROM bahasa"))
	   {
		   $a=0;
		   while($bar = mysqli_fetch_array($hsl))
		   {
			 $rsl[$a]['id']=$bar['id'];  
			 $rsl[$a]['name']=$bar['name'];
			 $rsl[$a]['flag']=$bar['flag'];
			 $a++;
		   }
	   }
	   return $rsl;
   }
}