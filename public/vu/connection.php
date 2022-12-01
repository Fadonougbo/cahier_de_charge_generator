<?php 



use App\Form;
use App\Validation;
use App\connectionClass\Verify;
use App\sqlClass\Crud;

$title="Login";
$style="style/css/connection";

$new_validation=new Validation($_POST);
$new_crud=new Crud();
$new_verify=new Verify();

/**
 * variable personnalié 
 * @var null
 */
$errorMessage=null;

/**
 * function de verification du formulaire
 * @var [type]
 */
[$errorTab]=$new_validation->verifyRules(
	  		[
		  		  "required"=>"*",
		  		 "lengthMin"=>[["pseudo",5]]

	  	    ]);

/**
 * redirection si user est deja connecté
 */
if($new_verify->isConnected())
{
	$id=$_SESSION['auth']["id"];
	header("location:{$router->generate('generateur',['id'=>$id])}");
}


try {

	if(!empty($_POST))
	{
		if(empty($errorTab))
		{

			/**
			 * selection de l'utilisateur depuis la base de donné
			 * @var [type]
			 */
			$user=$new_crud->selectElement("*","user_info")
			               ->where("pseudo",":pseudo")
			               ->executeReq("fetch",["pseudo"=>$_POST["pseudo"]]);
			    /**
			     * creaction de la section
			     * @var [type]
			     */
			  if(($user !== false) && ($user->password===$_POST['password']))
			  {

			  	$new_verify->startSession();
			  	$_SESSION['auth']=['pseudo'=>$user->pseudo,'id'=>$user->id];

			  	header("location:{$router->generate('indirectformulaire',["id"=>$user->id])}");
			  	
			  }else
			  {
			  	$errorMessage="Pseudo ou mot de pass incorrect";
			  }

		}else
		 {
			 $errorMessage="Pseudo ou mot de pass incorrect";
		 }
	}
	
} catch (PDOException $e) {
	echo $e->getMessage();
}

/**
 * generateur de formulaire
 * @var Form
 */
$new_form=new Form($errorTab,true);

 ?>

<?php if (!empty($errorMessage)): ?>
		<div>
			<h1><?= $errorMessage; ?></h1>
		</div>
	<?php endif ?>
<div class="containner" >
	<form action="" method="POST"  >
		 <?= $new_form->inp(["type"=>"text",
 		                    "champName"=>"pseudo",
 		                    "label"=>"user pseudo",
 		                     "value"=>"entrez votre pseudo"]) ?>
        <?= $new_form->inp(["type"=>"password",
                            "champName"=>"password",
                            "label"=>"user password",
                            "value"=>"entrez votre password"]) ?>
         <section>
 			<button type="submit">connection</button>
 		</section>
       <p><a href="<?= $router->generate('inscription') ?>">vous n'avez pas de compt? s'inscrire</a> </p>
	</form>
	
</div>

