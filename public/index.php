<?php
session_start();
date_default_timezone_set("Asia/Makassar");
define('ROOT',dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP',ROOT . 'app' . DIRECTORY_SEPARATOR );
define('VIEW',ROOT . 'app' . DIRECTORY_SEPARATOR .'view' . DIRECTORY_SEPARATOR);
define('MODEL',ROOT . 'app' . DIRECTORY_SEPARATOR .'model' . DIRECTORY_SEPARATOR);
define('CORE',ROOT . 'app' . DIRECTORY_SEPARATOR .'core' . DIRECTORY_SEPARATOR);
define('DATA',ROOT . 'app' . DIRECTORY_SEPARATOR .'data' . DIRECTORY_SEPARATOR);
define('VENDOR',ROOT . 'app' . DIRECTORY_SEPARATOR .'vendor' . DIRECTORY_SEPARATOR);
define('THEME',ROOT . 'app' . DIRECTORY_SEPARATOR .'theme' .DIRECTORY_SEPARATOR);
define('MODULE',ROOT . 'app' . DIRECTORY_SEPARATOR .'module' .DIRECTORY_SEPARATOR);
define('MODULEC',ROOT . 'app' . DIRECTORY_SEPARATOR .'module' .DIRECTORY_SEPARATOR .'controller' .DIRECTORY_SEPARATOR);
define('MODULEV',ROOT . 'app' . DIRECTORY_SEPARATOR .'module' .DIRECTORY_SEPARATOR .'view' .DIRECTORY_SEPARATOR);
define('MODULEM',ROOT . 'app' . DIRECTORY_SEPARATOR .'module' .DIRECTORY_SEPARATOR .'model' .DIRECTORY_SEPARATOR);
define('CONTROLLER',ROOT . 'app' . DIRECTORY_SEPARATOR .'controller' . DIRECTORY_SEPARATOR);

$module =[ROOT,APP,CORE,DATA,VENDOR,CONTROLLER,MODULEC];
$arrpath=[CORE,CONTROLLER,MODULEC];

foreach($arrpath as $dir)
{
		$ls = scandir($dir);
		foreach($ls as $dat)
		{
			if(strpos($dat,".php"))
			{
			   $path=$dir.$dat;
				//$path=str_replace("\\","/",$path);  
				//echo $path."<br>";				
			   require_once $path;
			}
		}

}

require_once VENDOR."autoload.php";

new Application;
