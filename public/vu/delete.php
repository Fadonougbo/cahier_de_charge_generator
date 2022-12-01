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

/*--------------------------*/
$new_verify->startSession();
$id=(int)$params["id"];
$cahier_id=(int)$params["cahier_id"];
$user_id=(int)$_SESSION['auth']["id"];
$new_helper->verifyUser($id,$user_id,"delete",["id"=>$user_id,"cahier_id"=>$cahier_id]);

$user_cahier_id=$new_crud->selectElement("*","user_cahier")
                         ->where("user_cahier.id",":cahier_id")
                         ->and("user_info_id=:user_id")
                          ->executeReq("fetch",["cahier_id"=>$cahier_id,"user_id"=>$user_id]);

 if (!$user_cahier_id) {
    
    header("location:{$router->generate('generateur',["id"=>$user_id])}?cahier_echec=1");
 }

/*------------------------*/

/*delete elements*/


  $returnValue=$new_crud->delete("user_cahier")
           ->where("user_cahier.id",":cahier_id")
           ->and("user_info_id=:user_id")
           ->executeReq(null,["cahier_id"=>$cahier_id,"user_id"=>$user_id]);

    if($returnValue)
    {
         header("location:{$router->generate('generateur',["id"=>$user_id])}?delete=1");
    }

 ?>