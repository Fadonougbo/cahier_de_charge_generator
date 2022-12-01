<?php 

use App\Form;
use App\Validation;
use App\connectionClass\Verify;
use App\helperClass\Helper;
use App\sqlClass\Crud;
use App\sqlClass\InitPdo;

/*les varibles */
$title="modification";
$script="../../js/formulaire";
$style="../../style/css/formulaire";

$new_validation=new Validation($_POST);
$new_crud=new Crud();
$new_verify=new Verify();
$pdo=InitPdo::newPdo("generateurDB");
$new_helper=new Helper($router);
$errorMessage=null;

/*------------------------------*/

[$inputErrorTab,$radioErrorTab]=$new_validation->verifyRules(
	  		[
		  		  "required"=>["nom","nombre_page"],
		  		 "lengthMin"=>[["pseudo",5]],
		  		 "integer"=>[['nombre_page'],["budget"]],
		  		 "min"=>[["nombre_page",1],["budget",1]],
		  		 "dateFormat"=>[["date_livraison","Y-m-d"]],
		  		 "radioVerify"=>["site_type","techno","site_contenue","image_optimisation","site_logo","site_couleur","site_police","site_design","site_reseau_sociaux","site_ads","site_suivie","site_seo","site_maintenance"]

	  	    ]);

/*------------------------------*/

/*--------------------------*/
$new_verify->startSession();
$id=(int)$params["id"];
$cahier_id=(int)$params["cahier_id"];
$user_id=(int)$_SESSION['auth']["id"];
$new_helper->verifyUser($id,$user_id,"modification",["id"=>$user_id,"cahier_id"=>$cahier_id]);

$user_cahier_id=$new_crud->selectElement("*","user_cahier")
                         ->where("user_cahier.id",":cahier_id")
                         ->and("user_info_id=:user_id")
                          ->executeReq("fetch",["cahier_id"=>$cahier_id,"user_id"=>$user_id]);

 if (!$user_cahier_id) {
 	
 	header("location:{$router->generate('generateur',["id"=>$user_id])}?cahier_echec=1");
 }

/*------------------------*/

try 
{		

	$pdo->beginTransaction();
   
   $projet_description=$new_helper->selectElementInTable("projet_description",$user_id,$cahier_id);

    $hebergement_info=$new_helper->selectElementInTable("hebergement_info",$user_id,$cahier_id);


     $site_info=$new_helper->selectElementInTable("site_info",$user_id,$cahier_id);
 
                               

      $design=$new_helper->selectElementInTable("design",$user_id,$cahier_id);


       $visibilite=$new_helper->selectElementInTable("visibilite",$user_id,$cahier_id);



       $containte=$new_helper->selectElementInTable("containte",$user_id,$cahier_id);


      $pdo->commit();


      /*traitement*/

      if(!empty($_POST))
      {
      	if(empty($inputErrorTab) && empty($radioErrorTab))
      	 {
      	 	$pdo->beginTransaction();

      	 	/*update projet _description*/

      	 	 $new_crud->update("projet_description")
      	 	          ->setNewValue("nom=:nom,description=:description,objectif=:objectif")
      	 	          ->where("user_cahier_id",":cahier_id")
      	 	          ->executeReq(null,["nom"=>$_POST["nom"],"description"=>$_POST["nom"],"objectif"=>$_POST["objectifs"],"cahier_id"=>$cahier_id]);

      	 	 /*update hebergement_info */

      	 	   $new_crud->update("hebergement_info")
      	 	          ->setNewValue("nom_de_domaine=:nom_de_domaine,hebergeur_name=:hebergeur_name")
      	 	          ->where("user_cahier_id",":cahier_id")
      	 	          ->executeReq(null,["nom_de_domaine"=>$_POST["nom_domaine"],"hebergeur_name"=>$_POST["hebergeur_name"],"cahier_id"=>$cahier_id]);

      	 	    /*update site_info */      
      	 	 $new_crud->update("site_info")
      	 	    ->setNewValue("site_type=:site_type,technologie=:technologie,nombre_page=:nombre_page,langue=:langue,site_contenue=:site_contenue,url_info=:url_info,image_optimisation=:image_optimisation,fonctionnalite=:fonctionnalite")
      	 	    ->where("user_cahier_id",":cahier_id")
      	 	    ->executeReq(null,[

								   "site_type"=>$_POST["site_type"],
								   "technologie"=>$_POST["techno"],
								   "nombre_page"=>(int)$_POST["nombre_page"],
								   "langue"=>$_POST["langue"][0],
								   "site_contenue"=>$_POST["site_contenue"],
								   "url_info"=>$_POST["url_info"],
								   "image_optimisation"=>$_POST["image_optimisation"],
								   "fonctionnalite"=>implode(",",$_POST['fonctionnalite']),
								   "cahier_id"=>$cahier_id
								]);

      	 	  /*update  design */

      	 	  	$new_crud->update("design")
      	 	          ->setNewValue("design_type=:design_type,logo_info=:logo_info,police=:police,couleur=:couleur")
      	 	          ->where("user_cahier_id",":cahier_id")
      	 	          ->executeReq(null,[
										      "design_type"=>$_POST["site_design"],
										      "logo_info"=>$_POST['site_logo'],
										      "police"=>$_POST["site_police"],
										      "couleur"=>$_POST['site_couleur'],
										      "cahier_id"=>$cahier_id
								         ]);

     /*update visibilite*/ 	 	          

  $new_crud->update("visibilite")
      	 	->setNewValue("current_list=:current_list,pub_status=:pub_status,reseaux_sociaux_info=:reseaux_sociaux_info,mots_cle=:mots_cle,seo=:seo,suivie_analytique=:suivie_analytique")
      	 	     ->where("user_cahier_id",":cahier_id")
      	 	               ->executeReq(null,[

      	 	               	                  "current_list"=>$_POST["concurrent_list"],
										      "pub_status"=>$_POST['site_ads'],
										      "reseaux_sociaux_info"=>$_POST["site_reseau_sociaux"],
										      "mots_cle"=>$_POST['mot_cle'],
										      "seo"=>$_POST['site_seo'],
										      "suivie_analytique"=>$_POST['site_suivie'],
										      "cahier_id"=>$cahier_id
										       ]);
      	 	   /*update table containte*/

    $new_crud->update("containte")
      	 	 ->setNewValue("budget=:budget,devise=:devise,livraison_date=:livraison_date,maintenance=:maintenance,info_plus=:info_plus")
      	 	  ->where("user_cahier_id",":cahier_id")
      	 	  ->executeReq(null,[
      	 	  		              "budget"=>(int)$_POST["budget"],
								  "devise"=>$_POST['devise'][0],
								  "livraison_date"=>$_POST["date_livraison"],
								  "maintenance"=>$_POST['site_maintenance'],
								  "info_plus"=>$_POST['infoPlus'],
								  "cahier_id"=>$cahier_id
      	 	  ]);

      	 	  $pdo->commit();

      	 	  header("location:{$router->generate('generateur',["id"=>$user_id])}?modification=1");
    
      	 }else
      	 {
      	 	$errorMessage="Veillez  corrigé vos erreur";
      	 }
      }

} catch (PDOException $e) 
{

	echo $e->getMessage();
	
}

$new_form=new Form($inputErrorTab,false);


 ?>

 <div id="modif" >
 	  <h1>MODIFICATION DES DONNEES </h1>
 </div>


<form action="" method="POST">
	 <div class="error" >
	 	 <?php if (!empty($errorMessage)): ?>
 	    <h2><?= $errorMessage; ?></h2>
     <?php endif ?>
	 </div>
	 <div  id="navigation" >
  	<section id="navigationContainner" >
	 			<button id="previous" class="nav" >&larr; Precedent </button>
	 			<button id="next" class="nav" >Suivant &rarr;</button>
	 			<div  id="option" >
	 				<button type="submit">Update</button>
	 			</div>

    </section>
  </div>
	<div class="containner" >
	 <div class="div_responsive" >
		<div class="parent" >
			<section class="div_title" >
		     <h1>1. Définition du projet</h1>
	      </section>
	       <!-- inp premet de generé des inputes/textearea -->
	       <section class="formContainner" >
						 <?= $new_form->inp(["type"=>"text",
				 		                    "champName"=>"nom",
				 		                    "label"=>"Le nom de votre projet",
				 		                     "value"=>$projet_description->nom]) ?>
				 		 <?= $new_form->inp(["type"=>"text",
				                            "champName"=>"description",
				                            "label"=>"Description du projet",
				                            "value"=>$projet_description->description]) ?>
				        <?= $new_form->inp(["type"=>"text",
                            "champName"=>"objectifs",
                            "label"=>"Objectifs du projet",
                            "value"=>$projet_description->objectif]) ?>

            </section>               	
          </div>
          <div class="parent" >
						  <section class="div_title">
					       <h1>2. Hébergement et nom(s) de domaine</h1>
				       </section>

				       <section class="formContainner">
									 <?= $new_form->inp(["type"=>"text",
							 		                    "champName"=>"nom_domaine",
							 		                    "label"=>"Nom de domaine",
							 		                     "value"=>$hebergement_info->nom_de_domaine]) ?>
							 		 <?= $new_form->inp(["type"=>"text",
				                            "champName"=>"hebergeur_name",
				                            "label"=>"Hébergement envisagé ou déjà souscrit",
				                            "value"=>$hebergement_info->hebergeur_name]) ?>

				               <section class="div_title">
						               <h1>3. Information sur le site web</h1>
					             </section>

					              <section>
									       	<p>Type de site web :</p>
									       	<!-- radio permet de geré des inpute de type radio -->
											       	<?= $new_form->radio([
											       		"name"=>"site_type",
											       		"valueList"=>["Site vitrine","Site portfolio","Site e-commerce","Site catalogue","Blog","Site Gouvernemental","Autre"],
											       		"multipleChecked"=>$site_info->site_type

											       	])?>
									       </section>

			            </section>                	
          </div>
    </div>

    <div class="div_responsive" >
          <div class="parent" >
							  <section class="div_title">
						          <h1>3.1. Information sur le site web</h1>
					       </section>
					       <section class="formContainner" >
									      
									       <section>
											       	<p>Technologie à utiliser :</p>
											       	<?= $new_form->radio([
											       		"name"=>"techno",
											       		"valueList"=>["WordPress","Drupal","Joomla","Django","Prestashop","Symfony","Laravel","Wix","Developpement maison"],
											       		"multipleChecked"=>$site_info->technologie

											       	])?>

									       </section>
									       <section>
										       	<p>Les contenus du site (textes) seront fournis par :</p>
										       	<?= $new_form->radio([
										       		"name"=>"site_contenue",
										       		"valueList"=>[" le prestataire","nos soins"],
										       		"multipleChecked"=>$site_info->site_contenue

										       	])?>
										       
										       	<p>Avez-vous besoin d'aide pour optimiser vos images ?</p>
										       	<?= $new_form->radio([
										       		"name"=>"image_optimisation",
										       		"valueList"=>["le prestataire se charge d'optimiser les images","nous fournissons des images déjà optimisées"],
										       		"multipleChecked"=>$site_info->image_optimisation

										       	])?>
									       	
									       </section>

                  </section>        	
          </div>
            <div class="parent" >
							  <section class="div_title">
						          <h1>3.2. Information sur le site web</h1>
					       </section>
					       <section class="formContainner">
					       	        <section>
									       	<p>La langue principale du site </p>
									       	<?= $new_form->select([
							                            "champName"=>"langue",
							                            "optList"=>["français","anglais","arabe","espagnole"],
							                            "currentOptList"=>isset($_POST['langue'])&&!empty($_POST['langue'])?$_POST['langue']:explode(",",$site_info->langue),
							                            "multipleSelect"=>false
							                            ]) ?>
									       </section>

									       <section>
									       	   <?= $new_form->inp(["type"=>"text",
							 		                    "champName"=>"url_info",
							 		                    "label"=>"Donnez des exemples (url) de sites que vous appréciez :",
							 		                     "value"=>$site_info->url_info]) ?>
									       </section>

									       <section>
									       	    <?= $new_form->inp(["type"=>"number",
							 		                    "champName"=>"nombre_page",
							 		                    "label"=>"Nombre totale de page",
							 		                     "value"=>$site_info->nombre_page]) ?>
									       </section>
					       </section>
					    </div>
		</div>

		   <div class="div_responsive" >
           <div class="parent" >
							  <section class="div_title">
						          <h1>3.3. Information sur le site web</h1>
					       </section>
					       <section class="formContainner" >

									       <section>
									       	<p>Fonctionnalités désirées</p>

									       	<!-- permet de generé le select -->
									       	<?= $new_form->select([
							                            "champName"=>"fonctionnalite",
							                            "optList"=>["site multilingue","formulaire simple","forum","livre d'or","flux instagram","Newsletter","Avis clients","temoignage","formulaire de don","partie réservé au membre"],
							                            "currentOptList"=>isset($_POST['fonnctionnalite'])&&!empty($_POST['fonnctionnalite'])?$_POST['fonnctionnalite']:explode(",",$site_info->fonctionnalite),
							                            "error"=>isset($errorTab["fonctionnalite"])?$errorTab["fonctionnalite"]:null

							                            ]) ?>
									       </section>

									       <section class="div_title">
					                 <h1>4. Le design</h1>
				                 </section>

				                   <section>
										       	<p>Le logo du site</p>
										       		<?= $new_form->radio([
										       		"name"=>"site_logo",
										       		"valueList"=>["nous désirons une création sur mesure","nous en possédons un mais nous souhaitons l'améliorer","nous vous fournirons les fichiers","nous ne souhaitons pas le faire appaître sur le site"],
										       		  "multipleChecked"=>$design->logo_info

									       	                   ])?>
						               </section>


						             <section>
										       	<p>police</p>
										       		<?= $new_form->radio([
													       		"name"=>"site_police",
													       		"valueList"=>["nous souhaitons des suggestions","nous les avons choisies"],
													       		"multipleChecked"=>$design->police
													       	     ])?>
							       	
						             </section>

					       </section>
					  </div>


           <div class="parent" >

		          	<section class="div_title">
					           <h1>4.1. Le design</h1>
				       </section>
				       <section class="formContainner" >
				       	    
						       <section>
								       	<p>couleur</p>
								       	<?= $new_form->radio([
								       		"name"=>"site_couleur",
								       		"valueList"=>["nous souhaitons des suggestions","nous souhaitons utiliser nos propres couleurs"],
								       		"multipleChecked"=>$design->couleur

								       	     ])?>
						        </section>
						       <section>
						       	<p>Le design global</p>
						       	<?= $new_form->radio([
						       		"name"=>"site_design",
						       		"valueList"=>["nous désirons la création d'un design sur mesure","nous souhaitons choisir un design parmi des modèles existants","nous souhaitons adapter le design parmi des modèles existants"],
						       		"multipleChecked"=>$design->design_type

						       	     ])?>
						       </section>

						        <section class="div_title" >
			     			        <h1>5. La visibilité</h1>
		                </section>

		                <section>
						       	   <?= $new_form->inp(["type"=>"text",
				 		                    "champName"=>"concurrent_list",
				 		                    "label"=>"Quels sont les principaux sites concurrents ?",
			 		                     "value"=>$visibilite->current_list],

			 		                 ) ?>
				            </section>

				       </section>

          </div>
   </div>

   	<div class="div_responsive" >
          <div class="parent" >

          	<section class="div_title" >
			     			<h1>5.1. La visibilité</h1>
		       </section>

		       	<section class="formContainner" >
				        
				       <section>
				       	   <?= $new_form->inp(["type"=>"text",
		 		                    "champName"=>"mot_cle",
		 		                    "label"=>"Quels sont les mots clés principaux sur lesquels vous désirez être référencé ?",
		 		                     "value"=>$visibilite->mots_cle]) ?>
				       </section>

				        <section>
				       	<p>Annonces publicitaires Google Ads</p>
				       	<?= $new_form->radio([
				       		"name"=>"site_ads",
				       		"valueList"=>[" nous souhaitons être accompagnés dans la création d'annonces publicitaires Google Ads","nous souhaiterions déléguer la gestion d'annonces publicitaires Google Ads","nous n'envisageons pas d'utiliser les services de Google Ads"],
				       		"multipleChecked"=>$visibilite->pub_status

				       	     ])?>
				       	
				       
				       </section>

				       <section>
							       	<p>Avez-vous besoin d'aide pour la création de vos réseaux sociaux ?</p>
							       	<?= $new_form->radio([
							       		"name"=>"site_reseau_sociaux",
							       		"valueList"=>["nous avons besoin que le prestataire s'occupe de la création des comptes de réseaux sociaux ","nous nous occupons de tout"],
							       		"multipleChecked"=>$visibilite->reseaux_sociaux_info

							       	     ])?>
				       	
				        </section>

				       
          </section>
         </div>

          <div class="parent" >

	          	<section class="div_title" >
				     			<h1>5.2. La visibilité</h1>
			       </section>

			       	<section class="formContainner" >
			       			

				       <section>
				       	<p>Concernant le référencement naturel (SEO)</p>
				       	<?= $new_form->radio([
				       		"name"=>"site_seo",
				       	"valueList"=>["nous avons besoin d'une stratégie SEO de départ","nous souhaitons nous charger de l'optimisation SEO"],
				       	"multipleChecked"=>$visibilite->seo
				       	     ])?>
				       	
				       
				       </section>

				       <section>
				       	<p>Concernant le suivi analytique</p>
				       	<?= $new_form->radio([
				       		"name"=>"site_suivie",
				       		"valueList"=>[" nous souhaitons pouvoir suivre le trafic du site de manière basique","nous souhaitons pouvoir suivre le trafic du site de manière approfondie","nous n'avons pas besoin de suivre le trafic du site"],
				       		"multipleChecked"=>$visibilite->suivie_analytique

				       	     ])?>
				       	
				       </section>


			       	</section>
		       </div>
  </div>

  	<div class="div_responsive" >
          <div class="parent" >
          	<section class="div_title" >
			          <h1>6. Les contraintes</h1>
		       </section>
		       <section class="formContainner" >

		       	    <section>

				       	<?= $new_form->inp(["type"=>"date",
		 		                    "champName"=>"date_livraison",
		 		                    "label"=>"À quelle date souhaitez-vous la livraison du site ?",
		 		                     "value"=>$containte->livraison_date]) ?>
				       	
				       </section>

				       <section id="budget_devise" >
				       	<?= $new_form->inp(["type"=>"number",
		 		                    "champName"=>"budget",
		 		                    "label"=>"Quel est votre budget ?",
		 		                     "value"=>$containte->budget]) ?>
		 		          <?= $new_form->select([
		                            "champName"=>"devise",
		                            "optList"=>["fcfa","euro","dollar"],
		                            "currentOptList"=>isset($_POST['devise'])&&!empty($_POST['devise'])?$_POST['devise']:explode(",",$containte->devise),
		                            "multipleSelect"=>false
		                            ]) ?>
				       </section>

				       <section>

				       		<p>Qui doit maintenir le site (sauvegarde, mises à jour, sécurité, etc.) ? </p>
				       		<?= $new_form->radio([
				       		"name"=>"site_maintenance",
				       		"valueList"=>["Le prestataire s'occupera de la maintenance du site durant une période définie","Nous prenons en charge la maintenance du site"],
				       		"multipleChecked"=>$containte->maintenance

				       	     ])?>
				       		
				       </section>

				   </section>
		   </div>

		   <div class="parent" >
          	<section class="div_title" >
			          <h1>7. Autres information</h1>
		       </section>
		       <section class="formContainner essai" >
		       	    <section>

				       	   <?= $new_form->inp(["type"=>"textarea",
		 		                    "champName"=>"infoPlus",
		 		                    "label"=>"Info supplémentaire",
		 		                     "value"=>$containte->info_plus]) ?>
				       	
				       </section>

		       </section>
		   </div>

		</div>

  </div>
 

</form>



