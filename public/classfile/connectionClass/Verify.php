<?php 

namespace App\connectionClass;

class Verify
{

	public function __construct()
	{

	}

	public  function startSession()
	{
		if(session_status()===PHP_SESSION_NONE)
		{
			session_start();
		}
	}

	public function verifyStatus($router)
	{

		$this->startSession();
		if(!isset($_SESSION['auth']))
		{	
			header("location:{$router->generate('connection')}");
		}
	}

	public function isConnected()
	{
		$this->startSession();
		$x=isset($_SESSION['auth'])? true : false;
		return $x;
	}



}





 ?>