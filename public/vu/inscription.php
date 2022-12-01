<?php 

use App\Form;
use App\Validation;
use App\connectionClass\Verify;
use App\sqlClass\Crud;
use App\sqlClass\InitPdo;

$title="Inscription";
$style="style/css/connection";

$new_validation=new Validation($_POST);
$new_crud=new Crud();
$new_verify=new Verify();
$pdo=InitPdo::newPdo("generateurDB");

$errorMessage=null;
$userExistMesssage=null;

[$errorTab]=$new_validation->verifyRules(
	  		[
		  		  "required"=>"*",
		  		 "lengthMin"=>[["pseudo",5]],
		  		 "emailVerify"=>[["email"]]

	  	    ]);

try {

	if(!empty($_POST))
	{
		if(empty($errorTab))
		{

			$pseudo=$_POST['pseudo'];
			$email=$_POST['email'];
			$password=$_POST['password'];

			$user=$new_crud->selectElement("*","user_info")
			               ->where("pseudo",":pseudo")
			               ->executeReq("fetch",["pseudo"=>$_POST["pseudo"]]);
			              
			 if($user === false)
			 {
			 	$new_crud->insert("user_info","pseudo,email,password")
						   ->values(":pseudo,:email,:password")
			               ->executeReq(null,["pseudo"=>$pseudo,"email"=>$email,"password"=>$password]);
			        $user_id=$new_crud->lastId();
			        
			        if(is_int((int)$user_id))
					  {
							$new_verify->startSession();
							$_SESSION['auth']=['pseudo'=>$pseudo,'id'=>$user_id];
							header("location:{$router->generate('generateur',["id"=>$user_id])}?create=1"); 	
					  }
								 

			 }else
			 {
			 	$userExistMesssage="Ce pseudo existe deja";
			 }

		}else
		{
			$userExistMesssage="Veillez entrz des informations valides ";
		}
	}
	
} catch (PDOException $e) {
	echo $e->getMessage();
}


$new_form=new Form($errorTab,true);

 ?>
<div>
 	<?php if (!empty($errorMessage)): ?>
		<div>
			<h2><?= $errorMessage; ?></h2>
		</div>
	<?php endif ?>
	<?php if (!empty($userExistMesssage)): ?>
		<div>
			<h1><?= $userExistMesssage; ?></h1>
		</div>
	<?php endif ?>

<div  class="containner" >
	
	<form action="" method="POST">
		 <?= $new_form->inp(["type"=>"text",
 		                    "champName"=>"pseudo",
 		                    "label"=>"user pseudo",
 		                     "value"=>"entrez votre pseudo"]) ?>
 		 <?= $new_form->inp(["type"=>"text",
                            "champName"=>"email",
                            "label"=>"user email",
                            "value"=>"entrez votre email"]) ?>
        <?= $new_form->inp(["type"=>"password",
                            "champName"=>"password",
                            "label"=>"user password",
                            "value"=>"entrez votre password"]) ?>
      <section>
 			<button type="submit">connection</button>
 	</section>
	</form>
	
</div>
</div>

