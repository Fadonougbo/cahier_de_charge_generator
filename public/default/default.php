<?php 

use App\connectionClass\Verify;


$new_verify=new Verify();

if ($new_verify->isConnected())
{
	$id=$_SESSION['auth']["id"];

} 


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title??"page sans nom"; ?></title>
	<link rel="stylesheet" href="<?= $style??null ?>.css">
</head>
<body>
	<header>

		<section class="logo_containner">
         <a href="<?= $router->generate("home")?>">&Gopf;</a>
        </section>
        <aside class="" >
		
			<section class="user_info" >
				 <?php if ($new_verify->isConnected()): ?>
					<p><?= $_SESSION['auth']["pseudo"] ?></p>
				 <?php endif ?>
					<a href="<?= $router->generate('connection'); ?>">connexion</a>
				 <?php if ($new_verify->isConnected()): ?>
					<a href="<?= $router->generate('generateur',['id'=>$id]) ?>">Dashboad</a>
					<a href="<?= $router->generate('deconnection'); ?>">deconnexion</a>
				  <?php endif ?>
			     
			</section>
		
		</aside>
		<section class="menuIconContainner">
			<span></span>
			<span></span>
			<span></span>
		</section>
	</header>
	<main>
		<?= $content; ?>
	</main>

 <script src="../js/default.js" ></script>
 <script src="<?= $script;  ?>.js" ></script>	
</body>
</html>