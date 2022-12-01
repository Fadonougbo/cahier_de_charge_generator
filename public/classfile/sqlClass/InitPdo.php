<?php 

namespace App\sqlClass;

use \PDO;

class InitPdo
{
	public static $pdo=null;

	public static function newPdo(string $dbname)
	{
		if(empty(self::$pdo))
		{
			self::$pdo=new PDO("mysql:host=localhost;dbname=$dbname","root","root",[
						PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ
					    ]);
		}

		return self::$pdo;
	}
}

 ?>