<?php

class leftmenu extends Model
{
	protected $conn2;
	protected $DB;
	protected $DB3;
	public $deretmenu=[];
	
   public function __construct()
	{
		
		$this->conn = $this->connect();		
		$dbql=[];
		if($dbql=$this->connect2())
		{
			$this->conn2 = $dbql['conn'];
			$this->DB = $dbql['DB'];
			
		}
		$this->DB3= $this->connect3();//instan DB
  }
  
 public function getAllModule($lang,$start,$level,$tipe,$akses)
  {
	  //$dd=[];
	   $DB=$this->DB3->table("module");
	   $arr= $DB->select()
				->where('status','=','1')
				->andWhere('parent','=',$start)
				->orderby(['parent','urutan'])
				->get(["col"=>["lang"],"val"=>["en"]]);
		//$this->deretmenu =[];	
		
        ////echo $start.",";		
		////echo count($arr);
					   
	 if(count($arr) > 0)
	   {
		   $level ++;
		   foreach($arr as $dat)
		   {
			   $parent = $dat['id'];
			   //for($i=0;$i< (int)$level * 2;$i++)
			     //  echo "-";
				   
			       //echo $dat['nama']."<br>";
				   $dat['level']=$level;
				   //$this->getHak($tipe,$dat['id'],$akses);
				   //echo "$tipe,$level,".$dat['id'].",$akses,<br>";
				   
				 if($this->getHak($tipe,$dat['id'],$akses))
				   {
						$this->deretmenu[]=$dat;
				   }
				   
				   $this->getAllModule($lang,$parent,$level,$tipe,$akses);
			   
		   }
		   
	   }
	
	//return $rsl;
		
  }
  
  public function getHak($tipe,$moduleid,$akses)
  {
	  
	  //return $this->getHakById('admin_hak','tipe_admin_id','module',$tipe,$moduleid,$akses);
	 
	 $DB=$this->DB3->table("admin_hak");
     $arr=$DB->select($akses)
	         ->where('tipe_admin_id','=',$tipe)
			 ->andWhere('module','=',$moduleid)
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
	
    		
  }
   
   
  
}