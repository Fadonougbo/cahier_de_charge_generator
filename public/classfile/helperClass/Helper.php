<?php 

namespace App\helperClass;

use App\sqlClass\Crud;
use Dompdf\Dompdf;


class Helper
{

	public function __construct(public $router)
	{
		$this->crud=new Crud();
	}

	public function verifyUser(int $id,int $user_id,string $urlInfo,?array $param=null)
	{
		if($id!==$user_id)
		{
			$paramsArray=empty($param)?["id"=>$user_id]:$param;
           header("location:{$this->router->generate($urlInfo,$paramsArray)}");
		}		
		
	}

	public function sendRedirectUrl(array $array1,array $array2,bool $traitement)
	{

		if (!empty($_POST) && (empty($array1) && empty($array2)) && $traitement) {
			
			return $this->router->generate("traitement",["id"=>1]);

		}else if(!empty($_POST) && (empty($array1) && empty($array2)) && !$traitement)
		{
			return "";
		}
	}

	public function selectElementInTable(string $tableName,int $user_id,int $cahier_id )
	{
		return $this->crud->selectElement("*","$tableName")
                                ->leftJoin("user_cahier","user_cahier.id","$tableName.user_cahier_id")
                                ->where("user_cahier.user_info_id",":user_id")
                                ->and("user_cahier.id=:cahier_id")
                                ->executeReq("fetch",["user_id"=>$user_id,"cahier_id"=>$cahier_id]);
	}

	public function pdf(string $path,$data)
	{					

						 $post=$data;
						 ob_start();
						  require $path;
						  $x=ob_get_clean();

		                $dompdf=new Dompdf();
						 $dompdf->loadHtml($x);
						 $dompdf->setPaper('A4','portrait');
						 $dompdf->render();
						 
						 $canvas = $dompdf->getCanvas();
						$canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
						    $text = "Page $pageNumber/$pageCount";
						    $font = $fontMetrics->getFont('monospace');
						    $pageWidth = $canvas->get_width();
						    $pageHeight = $canvas->get_height();
						    $size = 12;
						    $width = $fontMetrics->getTextWidth($text, $font, $size);
						    $canvas->text($pageWidth - $width - 20, $pageHeight - 20, $text, $font, $size);
						});

						 $dompdf->stream();


	}
}





 ?>