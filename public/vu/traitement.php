<?php 

use App\Form;
use App\Validation;
use App\connectionClass\Verify;
use App\helperClass\Helper;
use App\sqlClass\Crud;
use App\sqlClass\InitPdo;

/*les varibles */
/*$script="../js/formulaire";*/

$new_validation=new Validation($_POST);
$new_crud=new Crud();
$new_verify=new Verify();
$pdo=InitPdo::newPdo("generateurDB");
$new_helper=new Helper($router);

/*redirection si id n'est pas correct  */
$new_verify->startSession();
$id=(int)$params["id"];
$cahier_id=(int)$params["cahier_id"];
$user_id=(int)$_SESSION['auth']['id'];
$new_helper->verifyUser($id,$user_id,"traitement");

try {



	$pdo->beginTransaction();
   
	   $projet_description=$new_helper->selectElementInTable("projet_description",$user_id,$cahier_id);

	   $hebergement_info=$new_helper->selectElementInTable("hebergement_info",$user_id,$cahier_id);

     $site_info=$new_helper->selectElementInTable("site_info",$user_id,$cahier_id);
 
      $design=$new_helper->selectElementInTable("design",$user_id,$cahier_id);


       $visibilite=$new_helper->selectElementInTable("visibilite",$user_id,$cahier_id);



       $containte=$new_helper->selectElementInTable("containte",$user_id,$cahier_id);


      $pdo->commit();

  $arr=array_merge(array($projet_description),array($hebergement_info),array($site_info),array($design),array($visibilite),array($containte));

      $new_helper->pdf("htmlPdf/htmlPdf_with_dbinfo.php",$arr);
     die();

      
	
} catch (PDOException $e) {
	echo $e->getMessage();
}

 ?>

<p>okok</p>