<?php
class home extends Model
{
	protected $conn2;
	protected $DB;
	protected $DB3;
    public function __construct()
	{
		
		//$this->conn = $this->connect();		
		$dbql=[];
		if($dbql=$this->connect2())
		{
			$this->conn2 = $dbql['conn'];
			$this->DB = $dbql['DB'];
		}
		//$this->DB3= $this->connect3();
	}
	
   public function getHakPage($tipe,$modulename,$akses)
   {
	return $this->getHak($tipe,$modulename,$akses);    		
   }
	
}