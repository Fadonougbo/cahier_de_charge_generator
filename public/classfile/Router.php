<?php 

namespace App;



use \AltoRouter;

class Router
{
	public  $altorouter;

	public function __construct()
	{
		$this->altorouter=new AltoRouter();
	}

	public  function mapGET(string $pathName,string $fileName,string $name):self
	{
		$this->altorouter->map("GET",$pathName,$fileName,$name);
		return $this;
	}

	public  function mapPOST(string $pathName,string $fileName,string $name):self
	{
		$this->altorouter->map("POST",$pathName,$fileName,$name);
		return $this;
	}

	public function map(string $pathName,string $fileName,string $name):self
	{
		$this->altorouter->map("GET|POST",$pathName,$fileName,$name);
		return $this;
	}

	public function match()
	{
		$match=$this->altorouter->match();
		$router=$this->altorouter;
		$params=$match["params"];
		

		if($match)
		{
			ob_start();
			require $match['target'];
			$content=ob_get_clean();

			require "./default/default.php";
			
		}else
		{
			die("cette page n'exist pas");
		}
		
	}
}




 ?>