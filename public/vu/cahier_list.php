<?php 

use App\connectionClass\Verify;
use App\helperClass\Helper;
use App\sqlClass\Crud;

$new_verify=new Verify();
$new_verify->startSession();
$new_helper=new Helper($router);
$new_crud=new Crud();

$script="../../js/alert";
$title="Cahier list";
$style="../style/css/cahier_list";


/*--------------*/
$id=(int)$params["id"];
$user_id=(int)$_SESSION['auth']["id"];
$new_helper->verifyUser($id,$user_id,"generateur");
/*-----------------*/

try 
{


$elements=$new_crud->selectElement("nom,projet_description.user_cahier_id AS current_cahier","user_cahier")
                  ->leftJoin("projet_description","projet_description.user_cahier_id","user_cahier.id")
                  ->where("user_cahier.user_info_id",$user_id)
                  ->orderBy("user_cahier.id","DESC")
                  ->executeReq("fetchAll",[]);
    
} catch (PDOException $e) 
{

    echo $e->getMessage();

    
}


 ?>
<div>
       <div>
         <section id="title_containner" >
            <a href='<?= "{$router->generate('indirectformulaire',["id"=>$user_id])}"; ?>' id="title" >Generé un cahier de charge</a>
        </section>

          <div id="containner" >
              <?php foreach ($elements as $key => $el): ?>
                <section class="card_container">
                        <section class="projet_name" ><h1>Projet: <?= $el->nom ?> </h1></section>
                          <div>
                              <section><a href="<?= $router->generate("pdf",["id"=>$user_id,"cahier_id"=>$el->current_cahier]) ?>">Generé le pdf</a></section>
                              <section>
                                <a href="<?= $router->generate("modification",["id"=>$user_id,"cahier_id"=>$el->current_cahier]) ?>" class="update" >modifié</a>
                            </section>
                              <section>
                                <a href="<?= $router->generate("delete",["id"=>$user_id,"cahier_id"=>$el->current_cahier]) ?>" class="delete" >supprimé</a>
                              </section>
                          </div>
                </section>
              <?php endforeach ?>
                    
          </div>
    </div>

</div>

<div></div>


 