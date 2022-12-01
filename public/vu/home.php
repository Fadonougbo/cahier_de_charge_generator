<?php 

use App\connectionClass\Verify;

$title="Home";
$style="style/css/home";

$new_verify=new Verify();


 ?>

<div id="description" >
     <h2>
          Generé  vos <a href="https://fr.wikipedia.org/wiki/Cahier_des_charges">cahier des charges</a> ici gratuitement!
     </h2>
</div>

 <div id="home_parent" >
     
     <section>
   <a href="<?=
      $new_verify->isConnected()?$router->generate('indirectformulaire',['id'=>$_SESSION['auth']['id']]):$router->generate('connection'); 
   ?>">Generé un cahier des charges & sauvegardé </a>
     </section>
 	<section>
          <a href="<?=$router->generate('formulaire'); ?>">Generé un cahier des charges directement</a>
     </section>
    
 </div>